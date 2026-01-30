import {prepareAcceptGroup} from "./accept-group.state.js";

let yourGroupAccept = document.querySelector('.your-group__accept');

export function acceptGroupRender(players) {
    if (!yourGroupAccept) return;

    yourGroupAccept.innerHTML = '';

    players.forEach(player => {
        const slot = document.createElement('div');
        slot.classList.add('personal-accept');

        if (player.isMe) slot.classList.add('me');
        if (player.ready) slot.classList.add('ready');
        else slot.classList.add('not-ready');

        if (!player.isFriend) {
            slot.classList.add('not-friend');
        }


        // avatar / placeholder
        if (player.avatar) {
            const img = document.createElement('img');
            img.src = player.avatar;
            img.alt = player.nickname ?? '';
            slot.appendChild(img);
        } else {
            const placeholder = document.createElement('div');
            placeholder.classList.add('placeholder');
            slot.appendChild(placeholder);
        }

        yourGroupAccept.appendChild(slot);
    });
}

