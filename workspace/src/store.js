import io from "socket.io-client";
export const socket = io("http://localhost:5000");

import axiosBase from "axios";
export const axios = axiosBase.create({
    baseURL: `${location.origin}/api`,
    headers: {
        "Content-Type": "application/json"
    },
    responseType: "json"
});
window.socket = socket;

export const auth = {
    async login(name, password) {
        return await axios.post("/login", { name, password });
    },
    async logout() {
        return await axios.post("/logout");
    },
    isInitialized: false,
    async init() {
        const { data } = await axios.get("me").catch(console.dir);
        this.user = Object.assign({}, this.user, data);

    },
    user: {}
}

export async function watch(name, array, option = {}) {
    option = Object.assign({
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
    }, option)
    const { data } = await axios.get(option.url);
    console.log("get init data", data);
    data.forEach(instance => {
        Object.defineProperty(instance, "id", {
            value: instance._id,
            writable: false
        });
        delete instance._id;
    });
    array.splice(0, 0, ...data);
    socket.on(name, change => {
        console.log(change);
        const operationType = change.operationType;
        if (operationType == "insert") {
            option.insert(array, change);
        } else if (operationType == "update") {
            option.update(array, change);
        } else if (operationType == "delete") {
            option.delete(array, change);
        } else {
            console.error("登録されていないoperationTypeがある");
        }
    });
}
