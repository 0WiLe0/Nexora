import { state } from '../core/state.js';
import {post} from "../core/http.js";
import { startSearchPolling } from './match.polling.js';
import {startSearchingTimerUI} from "../ui/searching-timer.js";
import {serverAndGamemodeUI} from "../ui/server-mode.js";
import {renderCanceled} from "../ui/canceled.js";
import {renderSearch} from "../ui/search.js";
import {renderUI} from "../ui/render-ui.js";


let findBtn = document.querySelector('.ranked__find');
let searchBlock = document.querySelector('.search-play__block');

findBtn.addEventListener('click', async () => {

    if (state.roles.primary === null || state.roles.secondary === null) {
        alert('Роли не выбраны');
        return;
    }

    if(state.mode === null || state.server == null) {
        alert('Режим игры или Сервер не выбраны');
        return;
    }

    console.log('STATUS BEFORE FIND:', state.status);

    if(state.status !== 'idle'){
        return;
    }


    let response = await post('/matches');
    state.matchId = response.id;

    await post(`/matches/${state.matchId}/join`);

    state.status = 'searching';

    renderSearch();
    startSearchPolling();
    startSearchingTimerUI();
    serverAndGamemodeUI();
    renderUI();

    console.log(state.status);

    console.log('SEARCH STARTED', state);
});
