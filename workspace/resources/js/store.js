import firebase from "firebase";

const config = {
    apiKey: "AIzaSyDcuALcDWa_DjA5ALPPlpAy-J8SAQ2b9rc",
    authDomain: "smile-cycle.firebaseapp.com",
    databaseURL: "https://smile-cycle.firebaseio.com",
    projectId: "smile-cycle",
    storageBucket: "smile-cycle.appspot.com",
    messagingSenderId: "852568011973",
    appId: "1:852568011973:web:b6edc1ce3255bb26f92cac"
};

firebase.initializeApp(config);
const firestore = firebase.firestore();


const format = (date, format) => {
    const _fmt = {
        "yyyy": function (date) { return date.getFullYear() + ''; },
        "MM": function (date) { return ('0' + (date.getMonth() + 1)).slice(-2); },
        "dd": function (date) { return ('0' + date.getDate()).slice(-2); },
        "hh": function (date) { return ('0' + date.getHours()).slice(-2); },
        "mm": function (date) { return ('0' + date.getMinutes()).slice(-2); },
        "ss": function (date) { return ('0' + date.getSeconds()).slice(-2); }
    }
    const _priority = ["yyyy", "MM", "dd", "hh", "mm", "ss"]
    return _priority.reduce((res, fmt) => res.replace(fmt, _fmt[fmt](date)), format);
}

const CRUD = collection_name => {
    const db = firestore.collection(collection_name);
    const crud_obj = {
        loading: true,
        data: [],
        async create(item) {
            return db.add({
                ...item,
                created_at: format(new Date(), "yyyy-MM-dd"),
                edited_at: format(new Date(), "yyyy-MM-dd")
            });
        },
        async edit(edited_item) {
            const item = { ...edited_item, edited_at: format(new Date(), "yyyy-MM-dd") }
            delete item._id
            return db.doc(edited_item._id).set(item);
        },
        async delete(item) {
            return db.doc(item._id).delete()
        }
    }
    db.get().then(snapshot => {
        const items = []
        snapshot.forEach(doc => {
            items.push(Object.assign(doc.data(), { _id: doc.id }));
        })
        crud_obj.data = items;
        crud_obj.loading = false;
    })
    db.onSnapshot(snapshot => {
        const items = []
        snapshot.forEach(doc => {
            items.push(Object.assign(doc.data(), { _id: doc.id }));
        })
        crud_obj.data = items;
    });
    return crud_obj;
}
const store = {
    invitations: CRUD("invitations"),
    forums: CRUD("forums"),
    members: CRUD("members"),
    companies: CRUD("companies"),
    stamps: CRUD("stamps"),
    rooms: Object.assign(CRUD("rooms")),
    profile: {},
}

export default store