import { Link, useLocation } from 'react-router-dom';

const Sidebar = () => {
  const location = useLocation();
  const isUsersActive = location.pathname.startsWith('/users');

  return (
    <div className="w-16 bg-white border-r border-gray-200 flex flex-col items-center py-4 fixed left-0 top-0 h-full">
      {/* Navigation Icons - Only Users */}
      <nav className="flex flex-col space-y-6 mt-8">
        <Link
          to="/users"
          className={`w-10 h-10 flex items-center justify-center rounded-lg transition-colors ${
            isUsersActive
              ? 'bg-blue-100 text-blue-600'
              : 'text-gray-600 hover:bg-gray-100'
          }`}
          title="Users"
        >
          <svg className="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
          </svg>
        </Link>
      </nav>
    </div>
  );
};

export default Sidebar;
