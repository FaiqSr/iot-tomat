// Import the functions you need from the SDKs you need
import { initializeApp } from "firebase/app";
import { getAnalytics } from "firebase/analytics";
// TODO: Add SDKs for Firebase products that you want to use
// https://firebase.google.com/docs/web/setup#available-libraries

// Your web app's Firebase configuration
// For Firebase JS SDK v7.20.0 and later, measurementId is optional
const firebaseConfig = {
  apiKey: "AIzaSyBklilkdDe19SD5V9ixYHLb76_Rfv-fRH4",
  authDomain: "cibeng-347a6.firebaseapp.com",
  databaseURL: "https://cibeng-347a6-default-rtdb.asia-southeast1.firebasedatabase.app",
  projectId: "cibeng-347a6",
  storageBucket: "cibeng-347a6.firebasestorage.app",
  messagingSenderId: "620338273880",
  appId: "1:620338273880:web:59d4a6f5606f7f2074342d",
  measurementId: "G-E4MFN9DFDY"
};

// Initialize Firebase
const app = initializeApp(firebaseConfig);
const analytics = getAnalytics(app);

export { app };
export default firebaseConfig;
