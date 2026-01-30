import { state } from '../core/state.js';
import { post } from '../core/http.js';
import {startAcceptPolling} from "./match.polling.js";
import {stopAcceptTimer} from "./match.accept-timer.js";
import {setStatus} from "../core/state-utils.js";

let acceptBtn = document.querySelector('.accept-btn');
let acceptBlock = document.querySelector('.accept-play__block');
let personalAccept = document.querySelector('.personal-accept');


acceptBtn.addEventListener('click',async () => {
    if (state.status !== 'found'){
        return;
    }

    let response  = await post(`/matches/${state.matchId}/ready`);


    acceptBlock.classList.add('accepted');
    acceptBtn.disabled = true;
    personalAccept.classList.add('ready');

    stopAcceptTimer();
    startAcceptPolling();
});


