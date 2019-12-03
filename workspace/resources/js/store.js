import firebase from "firebase/app";
import "firebase/firestore";
import "firebase/functions";
import 'firebase/auth';
const config = {
    apiKey: "AIzaSyDcuALcDWa_DjA5ALPPlpAy-J8SAQ2b9rc",
    authDomain: "smile-cycle.firebaseapp.com",
    databaseURL: "https://smile-cycle.firebaseio.com",
    projectId: "smile-cycle",
    storageBucket: "smile-cycle.appspot.com",
    messagingSenderId: "852568011973",
    appId: "1:852568011973:web:b6edc1ce3255bb26f92cac"
};
window.test = firebase;
export default firebase.initializeApp(config).firestore();

firebase.auth().onAuthStateChanged(console.log);
