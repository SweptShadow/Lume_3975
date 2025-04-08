import { createBrowserRouter } from "react-router-dom";
import LandingPage from "../pages/LandingPage";
import OotdPage from "../pages/OotdPage";
// import OotdPost from "../pages/OotdPostPage";
// import Discover from "../pages/DiscoverPage";
import App from "../App";

/**
 * Define the application's routes.
 */
export const router = createBrowserRouter([
  {
    path: "/",
    element: <App />,
    children: [
      {
        path: "/",
        element: <LandingPage />
      },
      {
        path: "/ootd",
        element: <OotdPage />
      },
      // {
      //   path: "/ootd:id",
      //   element: <OotdPost />
      // }
    ],
  },
]);
