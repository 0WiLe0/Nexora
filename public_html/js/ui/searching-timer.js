import {state} from "../core/state.js";

let timerUI = document.querySelector('.timer-play');

let uiTimer = null;
let minute = 0;
let seconds = 0;


export function startSearchingTimerUI() {
    stopSearchingTimerUI();

    updateUI();

    uiTimer = setInterval(() => {

        if (state.status !== 'searching') {
            stopSearchingTimerUI();
            return;
        }

        seconds++;

        updateUI();
    }, 1000);
}

export function stopSearchingTimerUI(){
    clearInterval(uiTimer);
    uiTimer = null;

    minute = 0;
    seconds = 0;

    if (timerUI) timerUI.textContent = `00:00`;
}

function updateUI(){
    if (timerUI) {

        if (seconds > 59){
            minute++;
            seconds = 0;
        }

        let minutesBlock = minute < 10 ? "0" + minute : minute

        let secondsBlock = seconds < 10 ? "0" + seconds : seconds

        timerUI.textContent = `${minutesBlock}:${secondsBlock}`;
    }

}
