import { Link } from "react-router-dom";
import { API_BASE_URL } from "../config/index";

const Navbar = () =>
{
    return (
        <nav className="navbar navbar-expand-lg bg-white shadow-sm px-4">
            <div className="container-fluid">
                {/* Lume Logo */ }
                <Link className="navbar-brand fw-bold fs-3" to={API_BASE_URL}>
                    lumé
                </Link>

                {/* links */ }
                <div className="ms-auto">
                    <ul className="navbar-nav d-flex flex-row gap-4">
                        <li className="nav-item">
                            <Link className="nav-link" to={`${API_BASE_URL}/signup`}>Register</Link>
                        </li>
                        <li className="nav-item">
                            <Link className="nav-link" to={`${API_BASE_URL}/login`}>Login</Link>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    );
};

export default Navbar;
