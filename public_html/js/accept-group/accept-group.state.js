import { state } from '../core/state.js';

export function prepareAcceptGroup() {

    const matchPlayers = state.matchPlayers;
    const newMatchPlayers = matchPlayers.concat();


    let players = newMatchPlayers.sort( (a, b) => {
        if(a.id === state.meId) return -1;
        if(b.id === state.meId) return 1;
        return a.nickname.localeCompare(b.nickname)
    })

    return players.map( player =>{
        return {
            id: player.id,
            nickname: player.nickname,
            ready: player.is_ready,
            avatar: player.avatar,
            isMe: player.id === state.meId,
            isFriend: player.id === state.meId ? true : player.is_friend
        };

    });




}
