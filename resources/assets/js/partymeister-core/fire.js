import firebase from 'firebase';
import firebaseConfig from 'firebase-config.json';

var fire = firebase.initializeApp(firebaseConfig);
export default fire;