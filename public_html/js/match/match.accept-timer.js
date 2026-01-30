import { state } from "../core/state.js";
import {setStatus} from "../core/state-utils.js";

let timer = null;

export function startAcceptTimer(seconds = 30) {
    if (timer) return;

    timer = setTimeout(() => {
        if (state.status === 'found') {
            setStatus('expired');
        }
        stopAcceptTimer();
    }, seconds * 1000);
}

export function stopAcceptTimer() {
    clearTimeout(timer);
    timer = null;
}
