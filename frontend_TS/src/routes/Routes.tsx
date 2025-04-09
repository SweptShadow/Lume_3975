import { createBrowserRouter } from "react-router-dom";
import LandingPage from "../pages/LandingPage";
import OotdPage from "../pages/OotdPage";
import OotdPostPage from "../pages/OotdPostPage";
import DiscoverPage from "../pages/DiscoverPage";
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
        // The list of OOTD posts
        path: "/ootd",
        element: <OotdPage />
      },
      {
        // For each individual post
        path: "/ootd/:id",
        element: <OotdPostPage />
      },
      {
        path: "/discover",
        element: <DiscoverPage />
      },
    ],
  },
]);
