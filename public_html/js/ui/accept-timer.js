import {state} from "../core/state.js";

let timerUI = document.querySelector('.timer-accept');
let progressUI = document.querySelector('.progress');

let uiTimer = null;
let total = 30;
let left = 30;


export function startAcceptTimerUI(seconds = 30) {
    stopAcceptTimerUI();

    total = seconds;
    left = seconds;

    updateUI();

    uiTimer = setInterval(() => {

        if (state.status !== 'found') {
            stopAcceptTimerUI();
            return;
        }

        left--;

        if (left <= 0) {
            stopAcceptTimerUI();
            return;
        }

        updateUI();
    }, 1000);
}

export function stopAcceptTimerUI(){
    clearInterval(uiTimer);
    uiTimer = null;

    if (timerUI) timerUI.textContent = `${total} s`;
    if (progressUI) progressUI.style.width = `100%`;
}

function updateUI(){
    if (timerUI) {
        timerUI.textContent = `${left} s`;
    }

    if (progressUI) {
        const percent = (left / total) * 100;
        progressUI.style.width = `${percent}%`;
    }

}
