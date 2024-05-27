let draggableObjects;
let dropPoints;
let startButton;
let result;
let controls;
let dragContainer;
let dropContainer;
let data;
let deviceType = "";
let initialx = 0, initialy = 0;
let currentElement = "";
let moveElement = false;
let count = 0;
let correctCount = 0;
let incorrectCount = 0;
let maxIncorrectAttempts = 3;

const isTouchDevice = () => {
    try {
        document.createEvent("TouchEvent");
        deviceType = "Touch";
        return true;
    } catch (e) {
        deviceType = "mouse";
        return false;
    }
};

const randomValueGenerator = () => {
    return data[Math.floor(Math.random() * data.length)];
};

const stopGame = () => {
    controls.classList.remove("hide");
    if (result.innerText !== "YOU WON") {
        startButton.classList.remove("hide");
    } else {
        startButton.classList.add("hide");
    }
};

function dragStart(e) {
    if (isTouchDevice()) {
        initialx = e.touches[0].clientX;
        initialy = e.touches[0].clientY;
        moveElement = true;
        currentElement = e.target;
    } else {
        e.dataTransfer.setData("text", e.target.id);
    }
}

function dragOver(e) {
    e.preventDefault();
}

const touchMove = (e) => {
    if (moveElement) {
        e.preventDefault();
        let newX = e.touches[0].clientX;
        let newY = e.touches[0].clientY;
        let currentSelectedElement = document.getElementById(e.target.id);
        currentSelectedElement.parentElement.style.top = 
            currentSelectedElement.parentElement.offsetTop - (initialy - newY) + "px";
        currentSelectedElement.parentElement.style.left =
            currentSelectedElement.parentElement.offsetLeft -
            (initialx - newX) +
            "px";
        initialx = newX;
        initialy = newY;
    }
};

const drop = (e) => {
    e.preventDefault();
    if (isTouchDevice()) {
        moveElement = false;
        const currentDrop = document.querySelector(`div[data-id='${e.target.id}']`);
        const currentDropBound = currentDrop.getBoundingClientRect();
        if (
            initialx >= currentDropBound.left &&
            initialx <= currentDropBound.right &&
            initialy >= currentDropBound.top &&
            initialy <= currentDropBound.bottom
        ) {
            currentDrop.classList.add("dropped");
            currentElement.classList.add("hide");
            currentDrop.innerHTML = ``;
            currentDrop.insertAdjacentHTML(
                "afterbegin",
                `<img src="img src="../../img/img2/${currentElement.id}.png">`
            );
            
            count += 1;
            correctCount += 1;
        } else {
            incorrectCount += 1;
            if (incorrectCount >= maxIncorrectAttempts) {
                result.innerText = `YOU LOST`;
                stopGame();
                return;
            }
        }
    } else {
        const draggedElementData = e.dataTransfer.getData("text");
        const droppableElementData = e.target.getAttribute("data-id");
        if (draggedElementData === droppableElementData) {
            const draggedElement = document.getElementById(draggedElementData);
            e.target.classList.add("dropped");
            draggedElement.classList.add("hide");
            draggedElement.setAttribute("draggable", "false");
            e.target.innerHTML = ``;
            e.target.insertAdjacentHTML("afterbegin",
            `<img src="img src="../../img/img2/${draggedElementData}.png">`
        );
        
            count += 1;
            correctCount += 1;
        } else {
            incorrectCount += 1;
            if (incorrectCount >= maxIncorrectAttempts) {
                result.innerText = `YOU LOST`;
                stopGame();
                return;
            }
        }
    }
    if (correctCount == 3) {
        result.innerText = `YOU WON`;
        stopGame();
    }
};

const creator = () => {
    dragContainer.innerHTML = "";
    dropContainer.innerHTML = "";
    let randomData = [];
    for (let i = 1; i <= 3; i++) {
        let randomValue = randomValueGenerator();
        if (!randomData.includes(randomValue)) {
            randomData.push(randomValue);
        } else {
            i -= 1;
        }
    }
    for (let i of randomData) {
        const flagDiv = document.createElement("div");
        flagDiv.classList.add("draggable-image");
        flagDiv.setAttribute("draggable", true);
        if (isTouchDevice()) {
            flagDiv.style.position = "absolute";
        }
        flagDiv.innerHTML = `<img src="img src="../../img/img2/${i}.png" id="${i}">`;
        dragContainer.appendChild(flagDiv);
    }
    for (let i of data) {
        const countryDiv = document.createElement("div");
        countryDiv.innerHTML = `<div class='animals' data-id='${i}'>
    ${i.charAt(0).toUpperCase() + i.slice(1).replace("-", " ")}
    </div>`;
        dropContainer.appendChild(countryDiv);
    }
};

document.addEventListener("DOMContentLoaded", () => {
    startButton = document.getElementById("start");
    result = document.getElementById("result");
    controls = document.querySelector(".controls-container");
    dragContainer = document.querySelector(".draggable-objects");
    dropContainer = document.querySelector(".drop-points");
    data = [
        "sucio",
        "baño",
        "limpio"
    
    ];
    startButton.addEventListener("click", async () => {
        currentElement = "";
        controls.classList.add("hide");
        startButton.classList.add("hide");
        await creator();
        count = 0;
        correctCount = 0;
        incorrectCount = 0;
        dropPoints = document.querySelectorAll(".animals");
        draggableObjects = document.querySelectorAll(".draggable-image");
        draggableObjects.forEach((element) => {
            element.addEventListener("dragstart", dragStart);
            element.addEventListener("touchstart", dragStart);
            element.addEventListener("touchend", drop);
            element.addEventListener("touchmove", touchMove);
        });
        dropPoints.forEach((element) => {
            element.addEventListener("dragover", dragOver);
            element.addEventListener("drop", drop);
        });
    });
    
});
