import { Outlet } from 'react-router'
import  NavBar from './components/NavBar'
import 'bootstrap/dist/css/bootstrap.min.css';
import Footer from './components/Footer'
import './App.css'

function App() {

  //! Might need to change className for the app. it's coming from bootstrap.
  return(
    <div className="app d-flex flex-column min-vh-100">
      {
        <NavBar />
      }
      <main className="flex-grow-1">
        <Outlet />
      </main>
      {
        <Footer />
      }
    </div>
  );
}


export default App
