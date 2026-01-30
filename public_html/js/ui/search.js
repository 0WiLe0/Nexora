// ui/search.js
import { state } from '../core/state.js';

let searchBlock = document.querySelector('.search-play__block');

export function renderSearch() {
    if (state.status === 'searching') {
        searchBlock.classList.remove('hidden');
    } else {
        searchBlock.classList.add('hidden');
    }
}

