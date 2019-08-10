import firebase from 'firebase';
import firebaseConfig from 'firebase-config.json';

let fire = firebase.initializeApp(firebaseConfig);
export default fire;