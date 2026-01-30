import {state} from "../core/state.js";


export function setPartyFromResponse(resp) {
    if (!resp) return;

    state.party = {
        id: resp.party_id,
        status: resp.status,
        leader_id: resp.leader_id,
        max: resp.max ?? 5,
        members: (resp.members ?? []).map(m => ({
            ...m,
            roles: m.roles ?? []
        }))
    };
}
