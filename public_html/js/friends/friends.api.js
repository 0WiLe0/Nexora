import {get} from "../core/http.js";
import {state} from "../core/state.js";


export async function loadFriends(){
    const friends = await get('/api/friends');
    state.friends = friends ?? [];

}
