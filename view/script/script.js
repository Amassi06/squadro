function desactiverBoutons(classe) {
  const boutons = document.querySelectorAll("." + classe);
  boutons.forEach(function (bouton) {
    bouton.onclick = function (event) {
      if (bouton.classList.contains("btn-white")) {
        Swal.fire({
          title: "Action non autorisée",
          text: "Vous ne pouvez pas jouer maintenant, c’est le tour des noires.",
          icon: "warning",
          confirmButtonText: "OK",
        });
      } else {
        Swal.fire({
          title: "Action non autorisée",
          text: "Vous ne pouvez pas jouer maintenant, c’est le tour des blancs.",
          icon: "warning",
          confirmButtonText: "OK",
        });
      }
      event.preventDefault();
    };
  });
}

function demanderConfirmation(message) {
  return Swal.fire({
    title: "Êtes-vous sûr?",
    text: message,
    icon: "question",
    showCancelButton: true,
    confirmButtonText: "Oui",
    cancelButtonText: "Non",
    reverseButtons: true,
  }).then((result) => {
    if (result.isConfirmed) {
      return true;
    } else {
      return false;
    }
  });
}

function afficherVictoireSquadro(gagnant) {
  let couleurTexte = gagnant === 0 ? "#000000" : "#FFFFFF"; // Noir pour les blancs, blanc pour les noirs
  let background = gagnant === 0 ? "#F0F0F0" : "#2C2C2C"; // Gris clair pour les blancs, gris foncé pour les noirs
  let emoji = gagnant === 0 ? "⚪" : "⚫"; // Emoji pour différencier les équipes
  let titre = `Victoire des ${gagnant === 0 ? "Blancs" : "Noirs"} !`;
  let texte = `Les ${gagnant === 0 ? "Blancs" : "Noirs"} ont brillamment remporté la partie ! 🎉🏆`;

  Swal.fire({
    title: titre,
    text: texte,
    icon: "success",
    background: background,
    color: couleurTexte,
    confirmButtonColor: "#28A745",
    confirmButtonText: "Rejouer",
    showConfirmButton: true,
    allowOutsideClick: false
}).then((result) => {
    if (result.isConfirmed) {
        window.location.href = "index.php";
    }
});
lancerConfettis();

}

function lancerConfettis() {
  var duration = 10 * 1000; // Confettis pendant 10 secondes
  var animationEnd = Date.now() + duration;
  var defaults = {
    particleCount: 100,
    spread: 360,
    startVelocity: 40,
    ticks: 60,
    zIndex: 100,
    origin: { x: 0.5, y: 0.5 }
  };

  function randomInRange(min, max) {
    return Math.random() * (max - min) + min;
  }

  var interval = setInterval(function () {
    var timeLeft = animationEnd - Date.now();
    if (timeLeft <= 0) {
      return clearInterval(interval);
    }

    var particleCount = 50 * (timeLeft / duration);
    confetti(Object.assign({}, defaults, {
      particleCount: particleCount,
      origin: {
        x: randomInRange(0.2, 0.8),
        y: randomInRange(0.2, 0.8)
      }
    }));
  }, 250);
}


document.addEventListener("DOMContentLoaded", function () {
  let gameStatus = document.querySelector(".game-status");
  if (gameStatus && gameStatus.textContent.trim() === "Les blancs jouent") {
    Classe = "btn-white";
  } else {
    Classe = "btn-black";
  }
  document.querySelectorAll("." + Classe).forEach((button) => {
    button.addEventListener("click", function (event) {
      event.preventDefault();

     
      const form = event.target.closest("form");

     // Récupération et conversion des valeurs
const currentX = Number(form.querySelector("input[name='x']").value);
const currentY = Number(form.querySelector("input[name='y']").value);
const movement = Number(form.querySelector("input[name='v']").value);

// Fonction pour afficher le message d'erreur
function showError() {
  Swal.fire({
    icon: 'error',
    title: "vous ne pouvez pas jouer cette pièce, sa position d'arrivée est occupée",
    confirmButtonText: 'OK',
    confirmButtonColor: '#6C63FF',
  });
}

// Fonction qui vérifie si la destination est occupée par une pièce adverse
function destinationOccupied(destinationX, destinationY, opponentSelector) {
  return [...document.querySelectorAll(opponentSelector)].some(opponent => {
    const opponentForm = opponent.closest("form");
    const opponentX = Number(opponentForm.querySelector("input[name='x']").value);
    const opponentY = Number(opponentForm.querySelector("input[name='y']").value);
    return opponentX === destinationX && opponentY === destinationY;
  });
}

// Selon le type de pièce, on calcule la nouvelle position et on vérifie la destination
if (Classe === "btn-white") {
  const btn = event.target;
  // Calcul de la nouvelle coordonnée Y pour la pièce blanche
  const newY = btn.classList.contains("btn-right") ? currentY + movement : currentY - movement;
  
  // Vérification si la case (currentX, newY) est occupée par une pièce noire
  if (destinationOccupied(currentX, newY, ".btn-black")) {
    showError();
    return;
  }
}

if (Classe === "btn-black") {
  const btn = event.target;
  // Calcul de la nouvelle coordonnée X pour la pièce noire
  const newX = btn.classList.contains("btn-up") ? currentX - movement : currentX + movement;
  
  // Vérification si la case (newX, currentY) est occupée par une pièce blanche
  if (destinationOccupied(newX, currentY, ".btn-white")) {
    showError();
    return;
  }
}
      demanderConfirmation(
        "Êtes-vous sûr de vouloir effectuer cette action ?"
      ).then((confirmed) => {
        if (confirmed) {
          form.submit();
        }
      });
    });
  });
});

window.addEventListener("load", function() {
  window.scrollTo(0, document.body.scrollHeight);
});

//particles
particlesJS('particles-js', {
  particles: {
    number: {
      value: 250,  // Nombre de particules
      density: {
        enable: true,
        value_area: 800
      }
    },
    color: {
      value: '#32CD32'  // Couleur des particules
    },
    shape: {
      type: 'circle'  // Type de forme des particules
    },
    opacity: {
      value: 0.5,  // Opacité des particules
      random: true,
      anim: {
        enable: true,
        speed: 1,
        opacity_min: 0.1,
        sync: false
      }
    },
    size: {
      value: 6,  // Taille des particules
      random: true,
      anim: {
        enable: false
      }
    },
    line_linked: {
      enable: true,  // Lignes entre les particules
      distance: 100,  // Distance entre les particules liées
      color: '#ff7f50',  // Couleur des lignes
      opacity: 0.3,  // Opacité des lignes
      width: 1  // Largeur des lignes
    }
  },
  interactivity: {
    events: {
      onhover: {
        enable: true,
        mode: 'repulse'  // Effet de répulsion des particules au survol
      }
    }
  }
});
