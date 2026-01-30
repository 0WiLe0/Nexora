import {state} from "../core/state.js";
import {post} from "../core/http.js";
import {stopSearchPolling} from "./match.polling.js";
import {stopAcceptTimer} from "./match.accept-timer.js";
import {stopAcceptTimerUI} from "../ui/accept-timer.js";
import {stopSearchingTimerUI} from "../ui/searching-timer.js";
import {renderUI} from "../ui/render-ui.js";
import {setStatus} from "../core/state-utils.js";

let cancelSearchBtn = document.querySelector('.cancel-search__btn');

cancelSearchBtn.addEventListener('click', async () => {

    if (state.status !== 'searching'){
        return;
    }

    await post(`/matches/${state.matchId}/cancel`);

    stopSearchPolling();
    stopAcceptTimer();
    stopAcceptTimerUI();
    stopSearchingTimerUI()

    setStatus('idle');

    renderUI();
});
