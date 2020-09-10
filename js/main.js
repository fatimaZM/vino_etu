/**
 * @file Script contenant les fonctions de base
 * @author Jonathan Martel (jmartel@cmaisonneuve.qc.ca)
 * @version 0.1
 * @update 2019-01-21
 * @license Creative Commons BY-NC 3.0 (Licence Creative Commons Attribution - Pas d’utilisation commerciale 3.0 non transposé)
 * @license http://creativecommons.org/licenses/by-nc/3.0/deed.fr
 *
 */



//const BaseURL = "https://jmartel.webdev.cmaisonneuve.qc.ca/n61/vino/";

 const BaseURL = document.baseURI;

console.log(BaseURL);
window.addEventListener("load", function () {
  console.log("load");

  let bouteille = {
    nom: document.querySelector(".nom_bouteille"),
    millesime: document.querySelector("[name='millesime']"),
    quantite: document.querySelector("[name='quantite']"),
    date_achat: document.querySelector("[name='date_achat']"),
    prix: document.querySelector("[name='prix']"),
    garde_jusqua: document.querySelector("[name='garde_jusqua']"),
    notes: document.querySelector("[name='notes']"),
  };

  /* Comportement du bouton "boire" sur la page de cellier :*/
  document.querySelectorAll(".btnBoire").forEach(function (element) {
    element.addEventListener("click", function (evt) {
      let id = evt.target.parentElement.dataset.id;
      let requete = new Request(
        BaseURL + "index.php?requete=boireBouteilleCellier",
        { method: "POST", body: '{"id": ' + id + "}" }
      );

      fetch(requete)
        .then((response) => {
          if (response.status === 200) {
            //récupérer la quantité affichée de bouteille dans le cellier et soustraire 1
            element.parentElement.parentElement.querySelector(
              ".quantite"
            ).firstElementChild.innerHTML =
              parseInt(
                element.parentElement.parentElement.querySelector(".quantite")
                  .firstElementChild.innerHTML
              ) - 1;
            return response.json();
          } else {
            throw new Error("Erreur");
          }
        })
        .then((response) => {
          console.debug(response);
        })
        .catch((error) => {
          console.error(error);
        });
    });
  });

  /* Comportement du bouton "Ajouter" sur la page de cellier : */
  document.querySelectorAll(".btnAjouter").forEach(function (element) {
    element.addEventListener("click", function (evt) {
      let id = evt.target.parentElement.dataset.id;
      let requete = new Request(
        BaseURL + "index.php?requete=ajouterBouteilleCellier",
        { method: "POST", body: '{"id": ' + id + "}" }
      );

      fetch(requete)
        .then((response) => {
          if (response.status === 200) {
            //récupérer la quantité affichée de bouteille dans le cellier et ajouter 1
            element.parentElement.parentElement.querySelector(
              ".quantite"
            ).firstElementChild.innerHTML =
              parseInt(
                element.parentElement.parentElement.querySelector(".quantite")
                  .firstElementChild.innerHTML
              ) + 1;
            return response.json();
          } else {
            throw new Error("Erreur");
          }
        })
        .then((response) => {
          console.debug(response);
        })
        .catch((error) => {
          console.error(error);
        });
    });
  });

  /* comportement du formulaire d'ajout d'une nouvelle bouteille au cellier : */
  let inputNomBouteille = document.querySelector("[name='nom_bouteille']");
  console.log(inputNomBouteille);
  let liste = document.querySelector(".listeAutoComplete");

  //fonctionnement de l'auto-complétion :
  if (inputNomBouteille) {
    inputNomBouteille.addEventListener("keyup", function (evt) {
      console.log(evt);
      let nom = inputNomBouteille.value;
      liste.innerHTML = "";
      if (nom) {
        let requete = new Request(
          BaseURL + "index.php?requete=autocompleteBouteille",
          { method: "POST", body: '{"nom": "' + nom + '"}' }
        );
        fetch(requete)
          .then((response) => {
            if (response.status === 200) {
              return response.json();
            } else {
              throw new Error("Erreur");
            }
          })
          .then((response) => {
            console.log(response);

            response.forEach(function (element) {
              liste.innerHTML +=
                "<li data-id='" + element.id + "'>" + element.nom + "</li>";
            });
          })
          .catch((error) => {
            console.error(error);
          });
      }
    });

    //Affichage des résultats de recherche d'auto-complétion :
    liste.addEventListener("click", function (evt) {
      console.dir(evt.target);
      if (evt.target.tagName == "LI") {
        bouteille.nom.dataset.id = evt.target.dataset.id;
        bouteille.nom.innerHTML = evt.target.innerHTML;

        liste.innerHTML = "";
        inputNomBouteille.value = "";
      }
    });

    //Comportement du bouton "ajouter la bouteille" du formulaire d'ajout de bouteille au cellier :
    let btnAjouter = document.querySelector("[name='ajouterBouteilleCellier']");
    if (btnAjouter) {
      btnAjouter.addEventListener("click", function (evt) {
        var param = {
          id_cellier: 2,
          id_bouteille: bouteille.nom.dataset.id,
          date_achat: bouteille.date_achat.value,
          garde_jusqua: bouteille.garde_jusqua.value,
          notes: bouteille.notes.value,
          prix: bouteille.prix.value,
          quantite: bouteille.quantite.value,
          millesime: bouteille.millesime.value,
        };
        let requete = new Request(
          BaseURL + "index.php?requete=ajouterNouvelleBouteilleCellier",
          { method: "POST", body: JSON.stringify(param) }
        );

        let modal = document.querySelector(".modal");
        modal.style.display = "block";

        fetch(requete)
          .then((response) => {
            if (response.status === 200) {
              return response.json();
            } else {
              throw new Error("Erreur");
            }
          })
          .then((response) => {
            if (response.data == null) {
              document.querySelector(".millesime").innerHTML =
                response.erreurs.millesime || "";
              document.querySelector(".date_achat").innerHTML =
                response.erreurs.date_achat || "";
              document.querySelector(".garde_jusqua").innerHTML =
                response.erreurs.garde_jusqua || "";
              document.querySelector(".notes").innerHTML =
                response.erreurs.notes || "";
              document.querySelector(".prix").innerHTML =
                response.erreurs.prix || "";
              document.querySelector(".quantite").innerHTML =
                response.erreurs.quantite || "";
            }
            if (response.data == true) {
              console.log(document.querySelector(".msg_sql"));
              document.querySelector(".msg_sql").innerHTML = "Ajout effectué";
            } else {
              document.querySelector(".msg_sql").innerHTML = "Erreur d'ajout";
            }
          })
          .catch((error) => {
            console.error(error);
          });

        document
          .querySelector(".retour_cellier")
          .addEventListener("click", (_) => {
            window.location.href = BaseURL;
          });
      });
    }
  }

  //Comportement du bouton "modifier la bouteille" de la page modifier :
  let btnModifier = document.querySelector("[name='modifierBouteilleCellier']");
  if (btnModifier) {
    btnModifier.addEventListener("click", function (evt) {
      console.log("click btn modifier");
      var param = {
        id_cellier: 2,
        id_bouteille: bouteille.nom.dataset.id,
        date_achat: bouteille.date_achat.value,
        garde_jusqua: bouteille.garde_jusqua.value,
        notes: bouteille.notes.value,
        prix: bouteille.prix.value,
        quantite: bouteille.quantite.value,
        millesime: bouteille.millesime.value,
      };
      let requete = new Request(
        BaseURL + "index.php?requete=modifierBouteilleCellier",
        { method: "POST", body: JSON.stringify(param) }
      );

      let modal = document.querySelector(".modal");
      modal.style.display = "block";

      fetch(requete)
        .then((response) => {
          if (response.status === 200) {
            return response.json();
          } else {
            throw new Error("Erreur");
          }
        })
        .then((response) => {
          if (response.data == null) {
            console.log(response);
            document.querySelector(".millesime").innerHTML =
              response.erreurs.millesime || "";
            document.querySelector(".date_achat").innerHTML =
              response.erreurs.date_achat || "";
            document.querySelector(".garde_jusqua").innerHTML =
              response.erreurs.garde_jusqua || "";
            document.querySelector(".notes").innerHTML =
              response.erreurs.notes || "";
            document.querySelector(".prix").innerHTML =
              response.erreurs.prix || "";
            document.querySelector(".quantite").innerHTML =
              response.erreurs.quantite || "";
          }
          if (response.data == true) {
            console.log(document.querySelector(".msg_sql"));
            document.querySelector(".msg_sql").innerHTML =
              "Modification effectué";
          } else {
            document.querySelector(".msg_sql").innerHTML =
              "Erreur de modification";
          }
        })
        .catch((error) => {
          console.error(error);
        });
      document
        .querySelector(".retour_cellier")
        .addEventListener("click", (_) => {
          window.location.href = BaseURL;
        });
    });
  }
});
