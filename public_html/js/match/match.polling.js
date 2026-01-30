import { state } from '../core/state.js';
import { get } from '../core/http.js';
import {startAcceptTimer, stopAcceptTimer} from "./match.accept-timer.js";
import {resetAcceptUI, updateAcceptGroup} from "../ui/accept.js";
import {startAcceptTimerUI, stopAcceptTimerUI} from "../ui/accept-timer.js";
import {renderUI} from "../ui/render-ui.js";
import {setStatus} from "../core/state-utils.js";


let searchTimer = null;
let acceptTimer = null;


export function startSearchPolling() {
    if (searchTimer) return;

    searchTimer = setInterval(async () => {
        const match = await get(`/matches/${state.matchId}`);

        if (match.status === 'ready') {
            stopSearchPolling();

            setStatus('found');
            state.matchPlayers = match.players;

            renderUI();
            updateAcceptGroup();

            startAcceptTimer(30);
            startAcceptTimerUI(30);
            startAcceptPolling();
        }
    }, 2000);
}

export function stopSearchPolling() {
    clearInterval(searchTimer);
    searchTimer = null;
}

export function startAcceptPolling() {
    if (acceptTimer) return;

    acceptTimer = setInterval(async () => {
        const match = await get(`/matches/${state.matchId}`);

        if (state.status === 'found') {
            state.matchPlayers = match.players;
            updateAcceptGroup();

        }

        if (match.status === 'started') {
            stopAcceptPolling();
            stopAcceptTimer();
            stopAcceptTimerUI();
            window.location = `/lobby?match=${state.matchId}`;
        }

        if (match.status === 'expired' || match.status === 'canceled') {
            resetAcceptUI();
            state.matchId = null;

            stopAcceptPolling();
            stopAcceptTimer();
            stopAcceptTimerUI();

            setStatus('idle');
        }
    }, 2000);
}


export function stopAcceptPolling() {
    clearInterval(acceptTimer);
    acceptTimer = null;
}

