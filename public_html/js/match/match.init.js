import { get } from '../core/http.js';
import { state } from '../core/state.js';
import { startSearchPolling, startAcceptPolling } from './match.polling.js';
import { setStatus } from '../core/state-utils.js';

export async function initMatchFromServer() {
    const resp = await get('/matches/my');


    if (!resp || !resp.match) {
        state.matchId = null;
        setStatus('idle');
        return;
    }

    state.matchId = resp.match.id;


    switch (resp.match.status) {
        case 'searching':
            setStatus('searching');
            startSearchPolling();
            break;

        case 'ready':
            setStatus('found');
            startAcceptPolling();
            break;

        case 'accepted':
            setStatus('accepted');
            startAcceptPolling();
            break;

        case 'started':
            window.location = `/lobby?match=${state.matchId}`;
            break;

        default:
            setStatus('idle');
            state.matchId = null;
    }
}
