

function redirectToLevel(levelUrl) {
    window.location.href = levelUrl;
}

// Simulación de niveles completados
const levelsCompleted = {
    level1: false,
    level2: false,
    level3: false
};

document.addEventListener("DOMContentLoaded", () => {
    if (levelsCompleted.level1) {
        document.getElementById("level1-btn").disabled = true;
    }
    if (levelsCompleted.level2) {
        document.getElementById("level2-btn").disabled = true;
    }
    if (levelsCompleted.level3) {
        document.getElementById("level3-btn").disabled = true;
    }
});

