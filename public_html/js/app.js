// core
import './core/state.js'
import './core/http.js'

// ui
import './ui/roles.js'
import './ui/selects.js'
import './ui/search.js'
import './ui/accept.js'
import './ui/party.js'

// match
import './match/match.api.js'
import './match/match.search.js'
import './match/match.polling.js'
import './match/match.ready.js'
import './match/match.cancel.js'


import { state } from './core/state.js';
import { get } from './core/http.js';
import { renderAccept } from './ui/accept.js';
import {startAcceptPolling, startSearchPolling} from "./match/match.polling.js";
import {startAcceptTimer} from "./match/match.accept-timer.js";
import {renderParty} from "./ui/party.js";
import { initParty } from './party/party.init.js';
import {loadFriends} from "./friends/friends.api.js";
import {renderPartyInvite} from "./ui/party-invite.js";
import {renderPartyToast} from "./ui/party-toast.js";
import {renderUI} from "./ui/render-ui.js";
import {initMatchFromServer} from "./match/match.init.js";




let partyInterval = null;

async function initPlay() {
    await loadFriends();
    await initParty();
    await initMatchFromServer(); // 🔥 ВОТ ОН

    renderParty();
    renderPartyInvite();
    renderPartyToast();
    renderUI(); // если у тебя есть общий рендер

    if (!partyInterval) {
        partyInterval = setInterval(async () => {
            await initParty();
            renderPartyToast();
        }, 5000);
    }
}

initPlay();








