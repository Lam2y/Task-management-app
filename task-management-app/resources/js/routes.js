import AdminMainPage from './components/admin/AdminMainPage.vue';
import EmployeeMainPage from './components/employee/EmployeeMainPage.vue';
import AdminTaskManagement from './components/admin/AdminTaskManagement.vue';
import AdminLeaderboard from './components/admin/AdminLeaderboard.vue';
import AdminDashboard from './components/admin/AdminDashboard.vue';
import EmployeeDashboard from './components/employee/EmployeeDashboard.vue';
import EmployeeTimeline from './components/employee/EmployeeTimeline.vue';
import EmployeeTasks from './components/employee/EmployeeTasks.vue';

export default [
    {
        path: '/admin/mainpage',
        name: 'admin.mainpage',
        component: AdminMainPage,
    },
    {
        path: '/admin/taskmanagement',
        name: 'admin.taskmanagement',
        component: AdminTaskManagement,
    },
    {
        path: '/admin/leaderboard',
        name: 'admin.leaderboard',
        component: AdminLeaderboard,
    },
    {
        path: '/admin/dashboard',
        name: 'admin.dashboard',
        component: AdminDashboard,
    },
    {
        path: '/employee/mainpage',
        name: 'employee.mainpage',
        component: EmployeeMainPage,
    },
    {
        path: '/employee/tasks',
        name: 'employee.tasks',
        component: EmployeeTasks,
    },
    {
        path: '/employee/timeline',
        name: 'employee.timeline',
        component: EmployeeTimeline,
    },
    {
        path: '/employee/dashboard',
        name: 'employee.dashboard',
        component: EmployeeDashboard,
    },
];
