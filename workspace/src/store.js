import io from "socket.io-client";
export const socket = io();

import axiosBase from "axios";
export const axios = axiosBase.create({
    baseURL: `${location.origin}/api`,
    headers: {
        "Content-Type": "application/json"
    },
    responseType: "json"
});

export const auth = {
    async login(name, password) {
        return await axios.post("/login", { name, password });
    },
    async logout() {
        await axios.post("/logout");
        this.isInitialized = false;
        this.user = {};
        return
    },
    isInitialized: false,
    async init() {
        return axios.get("me").then(({ data }) => {
            this.isInitialized = true;
            this.user = Object.assign({}, this.user, data);
        }).catch(() => {

        });
    },
    user: {}

}
const cashe = {}
export function getWatchArray(name) {
    try {
        return cashe[name].array;
    } catch (error) {
        return null;
    }
}
export async function watch(name, array, option = {}) {
    cashe[name] = Object.assign(
        cashe[name] || {},
        {
            option: Object.assign({
                url: name,
                insert: function (array, change) {
                    const { documentId, document } = change;
                    Object.defineProperty(document, "id", {
                        value: documentId,
                        writable: false
                    });
                    array.splice(0, 0, document);
                },
                update: function (array, change) {
                    const { documentId, document } = change;
                    Object.defineProperty(document, "id", {
                        value: documentId,
                        writable: false
                    });
                    const index = array.findIndex(
                        instance => instance.id == documentId
                    );
                    if (index != -1) {
                        array.splice(index, 1, document);
                    }
                },
                delete: function (array, change) {
                    const { documentId } = change;
                    const index = array.findIndex(
                        instance => instance.id == documentId
                    );
                    if (index != -1) {
                        array.splice(index, 1);
                    }
                }
            }, option),
            array
        })
    const { data } = await axios.get(cashe[name].option.url);
    console.log("get init data", data);
    data.forEach(instance => {
        Object.defineProperty(instance, "id", {
            value: instance._id,
            writable: false
        });
        delete instance._id;
    });
    cashe[name].array.splice(0, 0, ...data);
    if (cashe[name].isInitialized) return;
    console.log("初期化された");
    socket.on(name, change => {
        console.log(change);
        const operationType = change.operationType;
        if (operationType == "insert") {
            cashe[name].option.insert(cashe[name].array, change);
        } else if (operationType == "update") {
            cashe[name].option.update(cashe[name].array, change);
        } else if (operationType == "delete") {
            cashe[name].option.delete(cashe[name].array, change);
        } else {
            console.error("登録されていないoperationTypeがある");
        }
    });
    cashe[name].isInitialized = true;
}
window.cashe = cashe;
