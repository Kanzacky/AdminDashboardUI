<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PageController extends Controller
{
    /**
     * Get current role from query parameter (defaults to superadmin).
     */
    private function getRole(Request $request): string
    {
        $allowed = ['superadmin', 'admin', 'manager', 'staff', 'viewer'];
        $role = strtolower($request->query('role', 'superadmin'));
        return in_array($role, $allowed) ? $role : 'superadmin';
    }

    /**
     * Get role display info.
     */
    private function getRoleInfo(string $role): array
    {
        $roles = [
            'superadmin' => ['label' => 'Super Admin', 'color' => 'danger', 'icon' => 'shield-check'],
            'admin'      => ['label' => 'Admin', 'color' => 'primary', 'icon' => 'shield'],
            'manager'    => ['label' => 'Manager', 'color' => 'accent', 'icon' => 'briefcase'],
            'staff'      => ['label' => 'Staff', 'color' => 'success', 'icon' => 'user'],
            'viewer'     => ['label' => 'Viewer', 'color' => 'neutral', 'icon' => 'eye'],
        ];
        return $roles[$role] ?? $roles['viewer'];
    }

    /**
     * Get sidebar menu items based on role.
     */
    private function getSidebarMenu(string $role): array
    {
        $allMenus = [
            [
                'group' => 'Main',
                'items' => [
                    ['name' => 'Dashboard', 'route' => 'dashboard', 'icon' => 'home', 'roles' => ['superadmin','admin','manager','staff','viewer']],
                    ['name' => 'Analytics', 'route' => 'analytics', 'icon' => 'chart-bar', 'roles' => ['superadmin','admin','manager']],
                    ['name' => 'Reports', 'route' => 'reports', 'icon' => 'document-chart-bar', 'roles' => ['superadmin','admin','manager','staff']],
                ],
            ],
            [
                'group' => 'Management',
                'items' => [
                    ['name' => 'Users', 'route' => 'users', 'icon' => 'users', 'roles' => ['superadmin','admin','manager'], 'badge' => '248'],
                    [
                        'name' => 'Roles', 'route' => 'roles', 'icon' => 'shield-check', 'roles' => ['superadmin','admin'],
                        'children' => [
                            ['name' => 'All Roles', 'route' => 'roles', 'roles' => ['superadmin','admin']],
                            ['name' => 'Permissions', 'route' => 'permissions', 'roles' => ['superadmin']],
                        ],
                    ],
                    ['name' => 'Menu Management', 'route' => 'menu-management', 'icon' => 'bars-3', 'roles' => ['superadmin']],
                ],
            ],
            [
                'group' => 'Monitoring',
                'items' => [
                    ['name' => 'Activity Log', 'route' => 'activity-log', 'icon' => 'clock', 'roles' => ['superadmin','admin','manager']],
                    ['name' => 'Notifications', 'route' => 'notifications', 'icon' => 'bell', 'roles' => ['superadmin','admin','manager','staff','viewer'], 'badge' => '5'],
                ],
            ],
            [
                'group' => 'System',
                'items' => [
                    ['name' => 'Settings', 'route' => 'settings', 'icon' => 'cog-6-tooth', 'roles' => ['superadmin','admin']],
                    ['name' => 'Help & Support', 'route' => 'help', 'icon' => 'question-mark-circle', 'roles' => ['superadmin','admin','manager','staff','viewer']],
                ],
            ],
        ];

        // Filter menu items by role
        $filtered = [];
        foreach ($allMenus as $group) {
            $items = [];
            foreach ($group['items'] as $item) {
                if (in_array($role, $item['roles'])) {
                    if (isset($item['children'])) {
                        $children = array_filter($item['children'], fn($c) => in_array($role, $c['roles']));
                        $item['children'] = array_values($children);
                    }
                    $items[] = $item;
                }
            }
            if (count($items) > 0) {
                $filtered[] = [
                    'group' => $group['group'],
                    'items' => $items,
                ];
            }
        }

        return $filtered;
    }

    /**
     * Common data for all authenticated pages.
     */
    private function commonData(Request $request): array
    {
        $role = $this->getRole($request);
        return [
            'currentRole'  => $role,
            'roleInfo'     => $this->getRoleInfo($role),
            'sidebarMenu'  => $this->getSidebarMenu($role),
            'currentRoute' => $request->route()->getName(),
            'currentUser'  => [
                'name'       => 'Andhika Pratama',
                'email'      => 'andhika@company.com',
                'avatar'     => null,
                'initials'   => 'AP',
                'department' => 'Technology',
                'role'       => $this->getRoleInfo($role)['label'],
            ],
            'notifications' => [
                ['id' => 1, 'title' => 'New user registered', 'message' => 'John Doe has created a new account', 'time' => '5 min ago', 'read' => false, 'type' => 'info'],
                ['id' => 2, 'title' => 'Server load high', 'message' => 'CPU usage exceeded 85% threshold', 'time' => '12 min ago', 'read' => false, 'type' => 'warning'],
                ['id' => 3, 'title' => 'Backup completed', 'message' => 'Daily backup finished successfully', 'time' => '1 hour ago', 'read' => true, 'type' => 'success'],
                ['id' => 4, 'title' => 'Payment received', 'message' => 'Invoice #INV-2024-0847 has been paid', 'time' => '2 hours ago', 'read' => false, 'type' => 'info'],
                ['id' => 5, 'title' => 'Security alert', 'message' => 'Unusual login attempt detected', 'time' => '3 hours ago', 'read' => false, 'type' => 'danger'],
            ],
        ];
    }

    // ──────────────────────────────────────────
    // AUTH PAGES
    // ──────────────────────────────────────────

    public function login()
    {
        return view('pages.auth.login');
    }

    public function register()
    {
        return view('pages.auth.register');
    }

    public function forgotPassword()
    {
        return view('pages.auth.forgot-password');
    }

    // ──────────────────────────────────────────
    // DASHBOARD
    // ──────────────────────────────────────────

    public function dashboard(Request $request)
    {
        $data = $this->commonData($request);

        $data['kpiCards'] = [
            [
                'title' => 'Total Users',
                'value' => '24,812',
                'change' => '+12.5%',
                'trend' => 'up',
                'icon' => 'users',
                'color' => 'brand',
                'description' => 'vs last month',
            ],
            [
                'title' => 'Revenue',
                'value' => '$84,254',
                'change' => '+8.2%',
                'trend' => 'up',
                'icon' => 'currency-dollar',
                'color' => 'success',
                'description' => 'vs last month',
            ],
            [
                'title' => 'Active Tasks',
                'value' => '1,429',
                'change' => '-3.1%',
                'trend' => 'down',
                'icon' => 'clipboard-document-check',
                'color' => 'warning',
                'description' => 'vs last week',
            ],
            [
                'title' => 'Growth Rate',
                'value' => '23.6%',
                'change' => '+4.7%',
                'trend' => 'up',
                'icon' => 'arrow-trending-up',
                'color' => 'accent',
                'description' => 'quarterly trend',
            ],
        ];

        $data['recentActivities'] = [
            ['user' => 'Sarah Wilson', 'initials' => 'SW', 'action' => 'created a new project', 'target' => 'E-Commerce Redesign', 'time' => '2 min ago', 'type' => 'create'],
            ['user' => 'Michael Chen', 'initials' => 'MC', 'action' => 'updated user permissions for', 'target' => 'Marketing Team', 'time' => '15 min ago', 'type' => 'update'],
            ['user' => 'Emily Davis', 'initials' => 'ED', 'action' => 'deleted inactive account', 'target' => 'legacy_user_042', 'time' => '32 min ago', 'type' => 'delete'],
            ['user' => 'James Rodriguez', 'initials' => 'JR', 'action' => 'exported report', 'target' => 'Q4 Financial Summary', 'time' => '1 hour ago', 'type' => 'export'],
            ['user' => 'Lisa Thompson', 'initials' => 'LT', 'action' => 'assigned role', 'target' => 'Manager to David Kim', 'time' => '2 hours ago', 'type' => 'update'],
            ['user' => 'Robert Brown', 'initials' => 'RB', 'action' => 'completed system backup', 'target' => 'Production Server', 'time' => '3 hours ago', 'type' => 'system'],
        ];

        $data['summaryTable'] = [
            ['id' => 'TRX-2024-0891', 'customer' => 'Tech Solutions Inc.', 'amount' => '$12,450', 'status' => 'completed', 'date' => 'Mar 28, 2024'],
            ['id' => 'TRX-2024-0890', 'customer' => 'Global Media Corp.', 'amount' => '$8,720', 'status' => 'processing', 'date' => 'Mar 28, 2024'],
            ['id' => 'TRX-2024-0889', 'customer' => 'Startup Hub Ltd.', 'amount' => '$3,150', 'status' => 'completed', 'date' => 'Mar 27, 2024'],
            ['id' => 'TRX-2024-0888', 'customer' => 'Creative Agency', 'amount' => '$6,890', 'status' => 'pending', 'date' => 'Mar 27, 2024'],
            ['id' => 'TRX-2024-0887', 'customer' => 'DataFlow Systems', 'amount' => '$15,200', 'status' => 'completed', 'date' => 'Mar 26, 2024'],
        ];

        return view('pages.dashboard', $data);
    }

    // ──────────────────────────────────────────
    // USERS
    // ──────────────────────────────────────────

    public function users(Request $request)
    {
        $data = $this->commonData($request);

        $data['users'] = [
            ['id' => 1, 'name' => 'Sarah Wilson', 'email' => 'sarah.wilson@company.com', 'initials' => 'SW', 'role' => 'Admin', 'department' => 'Engineering', 'status' => 'active', 'lastActive' => '2 min ago', 'joinDate' => 'Jan 15, 2023'],
            ['id' => 2, 'name' => 'Michael Chen', 'email' => 'michael.chen@company.com', 'initials' => 'MC', 'role' => 'Manager', 'department' => 'Product', 'status' => 'active', 'lastActive' => '15 min ago', 'joinDate' => 'Mar 22, 2023'],
            ['id' => 3, 'name' => 'Emily Davis', 'email' => 'emily.davis@company.com', 'initials' => 'ED', 'role' => 'Staff', 'department' => 'Marketing', 'status' => 'active', 'lastActive' => '1 hour ago', 'joinDate' => 'Jun 08, 2023'],
            ['id' => 4, 'name' => 'James Rodriguez', 'email' => 'james.r@company.com', 'initials' => 'JR', 'role' => 'Staff', 'department' => 'Finance', 'status' => 'inactive', 'lastActive' => '3 days ago', 'joinDate' => 'Aug 14, 2023'],
            ['id' => 5, 'name' => 'Lisa Thompson', 'email' => 'lisa.t@company.com', 'initials' => 'LT', 'role' => 'Manager', 'department' => 'Operations', 'status' => 'active', 'lastActive' => '30 min ago', 'joinDate' => 'Nov 03, 2022'],
            ['id' => 6, 'name' => 'Robert Brown', 'email' => 'robert.b@company.com', 'initials' => 'RB', 'role' => 'Viewer', 'department' => 'Support', 'status' => 'active', 'lastActive' => '5 hours ago', 'joinDate' => 'Feb 19, 2024'],
            ['id' => 7, 'name' => 'Amanda Lee', 'email' => 'amanda.l@company.com', 'initials' => 'AL', 'role' => 'Admin', 'department' => 'Engineering', 'status' => 'active', 'lastActive' => '10 min ago', 'joinDate' => 'Apr 05, 2023'],
            ['id' => 8, 'name' => 'David Kim', 'email' => 'david.kim@company.com', 'initials' => 'DK', 'role' => 'Staff', 'department' => 'Design', 'status' => 'suspended', 'lastActive' => '1 week ago', 'joinDate' => 'Sep 12, 2023'],
            ['id' => 9, 'name' => 'Jessica Martinez', 'email' => 'jessica.m@company.com', 'initials' => 'JM', 'role' => 'Manager', 'department' => 'HR', 'status' => 'active', 'lastActive' => '45 min ago', 'joinDate' => 'Jul 28, 2023'],
            ['id' => 10, 'name' => 'Thomas Wright', 'email' => 'thomas.w@company.com', 'initials' => 'TW', 'role' => 'Viewer', 'department' => 'Legal', 'status' => 'active', 'lastActive' => '2 hours ago', 'joinDate' => 'Dec 01, 2023'],
            ['id' => 11, 'name' => 'Olivia Johnson', 'email' => 'olivia.j@company.com', 'initials' => 'OJ', 'role' => 'Staff', 'department' => 'Marketing', 'status' => 'active', 'lastActive' => '20 min ago', 'joinDate' => 'Oct 17, 2023'],
            ['id' => 12, 'name' => 'Daniel Park', 'email' => 'daniel.p@company.com', 'initials' => 'DP', 'role' => 'Staff', 'department' => 'Engineering', 'status' => 'inactive', 'lastActive' => '2 weeks ago', 'joinDate' => 'May 30, 2023'],
        ];

        $data['userStats'] = [
            'total' => 248,
            'active' => 231,
            'inactive' => 12,
            'suspended' => 5,
        ];

        return view('pages.users', $data);
    }

    // ──────────────────────────────────────────
    // ROLES
    // ──────────────────────────────────────────

    public function roles(Request $request)
    {
        $data = $this->commonData($request);

        $data['roles'] = [
            [
                'id' => 1, 'name' => 'Super Admin', 'slug' => 'superadmin', 'description' => 'Full system access with all permissions. Can manage all aspects of the application.',
                'color' => 'danger', 'userCount' => 3, 'permissionCount' => 48, 'level' => 1, 'isSystem' => true,
            ],
            [
                'id' => 2, 'name' => 'Admin', 'slug' => 'admin', 'description' => 'Administrative access with user and content management capabilities.',
                'color' => 'primary', 'userCount' => 8, 'permissionCount' => 36, 'level' => 2, 'isSystem' => true,
            ],
            [
                'id' => 3, 'name' => 'Manager', 'slug' => 'manager', 'description' => 'Team management access with reporting and approval capabilities.',
                'color' => 'accent', 'userCount' => 24, 'permissionCount' => 22, 'level' => 3, 'isSystem' => false,
            ],
            [
                'id' => 4, 'name' => 'Staff', 'slug' => 'staff', 'description' => 'Standard access for day-to-day operations and task management.',
                'color' => 'success', 'userCount' => 156, 'permissionCount' => 14, 'level' => 4, 'isSystem' => false,
            ],
            [
                'id' => 5, 'name' => 'Viewer', 'slug' => 'viewer', 'description' => 'Read-only access. Can view dashboards and reports without modification rights.',
                'color' => 'neutral', 'userCount' => 57, 'permissionCount' => 6, 'level' => 5, 'isSystem' => false,
            ],
        ];

        $data['permissionGroups'] = [
            'User Management' => ['users.view', 'users.create', 'users.edit', 'users.delete', 'users.export'],
            'Role Management' => ['roles.view', 'roles.create', 'roles.edit', 'roles.delete', 'roles.assign'],
            'Content' => ['content.view', 'content.create', 'content.edit', 'content.delete', 'content.publish'],
            'Reports' => ['reports.view', 'reports.create', 'reports.export', 'reports.schedule'],
            'Settings' => ['settings.view', 'settings.edit', 'settings.security', 'settings.integrations'],
            'System' => ['system.logs', 'system.backup', 'system.maintenance', 'system.api-keys'],
        ];

        $data['permissionMatrix'] = [
            'superadmin' => ['users.view','users.create','users.edit','users.delete','users.export','roles.view','roles.create','roles.edit','roles.delete','roles.assign','content.view','content.create','content.edit','content.delete','content.publish','reports.view','reports.create','reports.export','reports.schedule','settings.view','settings.edit','settings.security','settings.integrations','system.logs','system.backup','system.maintenance','system.api-keys'],
            'admin' => ['users.view','users.create','users.edit','users.delete','users.export','roles.view','roles.create','roles.edit','roles.assign','content.view','content.create','content.edit','content.delete','content.publish','reports.view','reports.create','reports.export','settings.view','settings.edit','system.logs'],
            'manager' => ['users.view','users.edit','content.view','content.create','content.edit','content.publish','reports.view','reports.create','reports.export','reports.schedule'],
            'staff' => ['users.view','content.view','content.create','content.edit','reports.view'],
            'viewer' => ['users.view','content.view','reports.view'],
        ];

        return view('pages.roles', $data);
    }

    // ──────────────────────────────────────────
    // PERMISSIONS
    // ──────────────────────────────────────────

    public function permissions(Request $request)
    {
        $data = $this->commonData($request);
        $data['permissionGroups'] = [
            'User Management' => [
                ['name' => 'users.view', 'label' => 'View Users', 'description' => 'Can view user listings and profiles'],
                ['name' => 'users.create', 'label' => 'Create Users', 'description' => 'Can create new user accounts'],
                ['name' => 'users.edit', 'label' => 'Edit Users', 'description' => 'Can modify existing user details'],
                ['name' => 'users.delete', 'label' => 'Delete Users', 'description' => 'Can remove user accounts'],
                ['name' => 'users.export', 'label' => 'Export Users', 'description' => 'Can export user data to CSV/Excel'],
            ],
            'Role Management' => [
                ['name' => 'roles.view', 'label' => 'View Roles', 'description' => 'Can view role definitions'],
                ['name' => 'roles.create', 'label' => 'Create Roles', 'description' => 'Can create new roles'],
                ['name' => 'roles.edit', 'label' => 'Edit Roles', 'description' => 'Can modify role permissions'],
                ['name' => 'roles.delete', 'label' => 'Delete Roles', 'description' => 'Can remove roles from system'],
                ['name' => 'roles.assign', 'label' => 'Assign Roles', 'description' => 'Can assign roles to users'],
            ],
            'Content Management' => [
                ['name' => 'content.view', 'label' => 'View Content', 'description' => 'Can view published and draft content'],
                ['name' => 'content.create', 'label' => 'Create Content', 'description' => 'Can create new articles and pages'],
                ['name' => 'content.edit', 'label' => 'Edit Content', 'description' => 'Can modify existing content'],
                ['name' => 'content.delete', 'label' => 'Delete Content', 'description' => 'Can remove content permanently'],
                ['name' => 'content.publish', 'label' => 'Publish Content', 'description' => 'Can publish or unpublish content'],
            ],
            'Reports & Analytics' => [
                ['name' => 'reports.view', 'label' => 'View Reports', 'description' => 'Can access report dashboards'],
                ['name' => 'reports.create', 'label' => 'Create Reports', 'description' => 'Can generate custom reports'],
                ['name' => 'reports.export', 'label' => 'Export Reports', 'description' => 'Can export reports to PDF/Excel'],
                ['name' => 'reports.schedule', 'label' => 'Schedule Reports', 'description' => 'Can set up automated report delivery'],
            ],
            'System Settings' => [
                ['name' => 'settings.view', 'label' => 'View Settings', 'description' => 'Can view system configuration'],
                ['name' => 'settings.edit', 'label' => 'Edit Settings', 'description' => 'Can modify system settings'],
                ['name' => 'settings.security', 'label' => 'Security Settings', 'description' => 'Can manage authentication and security'],
                ['name' => 'settings.integrations', 'label' => 'Integrations', 'description' => 'Can manage third-party integrations'],
            ],
            'System Administration' => [
                ['name' => 'system.logs', 'label' => 'View System Logs', 'description' => 'Can access application and error logs'],
                ['name' => 'system.backup', 'label' => 'System Backup', 'description' => 'Can create and restore backups'],
                ['name' => 'system.maintenance', 'label' => 'Maintenance Mode', 'description' => 'Can toggle maintenance mode'],
                ['name' => 'system.api-keys', 'label' => 'API Keys', 'description' => 'Can manage API keys and tokens'],
            ],
        ];

        $data['rolePermissions'] = [
            'Super Admin' => array_map(fn($g) => array_map(fn($p) => $p['name'], $g), $data['permissionGroups']),
            'Admin' => [
                'User Management' => ['users.view','users.create','users.edit','users.delete','users.export'],
                'Role Management' => ['roles.view','roles.create','roles.edit','roles.assign'],
                'Content Management' => ['content.view','content.create','content.edit','content.delete','content.publish'],
                'Reports & Analytics' => ['reports.view','reports.create','reports.export'],
                'System Settings' => ['settings.view','settings.edit'],
                'System Administration' => ['system.logs'],
            ],
            'Manager' => [
                'User Management' => ['users.view','users.edit'],
                'Content Management' => ['content.view','content.create','content.edit','content.publish'],
                'Reports & Analytics' => ['reports.view','reports.create','reports.export','reports.schedule'],
            ],
            'Staff' => [
                'User Management' => ['users.view'],
                'Content Management' => ['content.view','content.create','content.edit'],
                'Reports & Analytics' => ['reports.view'],
            ],
            'Viewer' => [
                'User Management' => ['users.view'],
                'Content Management' => ['content.view'],
                'Reports & Analytics' => ['reports.view'],
            ],
        ];

        return view('pages.permissions', $data);
    }

    // ──────────────────────────────────────────
    // MENU MANAGEMENT
    // ──────────────────────────────────────────

    public function menuManagement(Request $request)
    {
        $data = $this->commonData($request);

        $data['menuItems'] = [
            ['id' => 1, 'name' => 'Dashboard', 'icon' => 'home', 'route' => '/dashboard', 'order' => 1, 'enabled' => true, 'roles' => ['superadmin','admin','manager','staff','viewer'], 'children' => []],
            ['id' => 2, 'name' => 'Analytics', 'icon' => 'chart-bar', 'route' => '/analytics', 'order' => 2, 'enabled' => true, 'roles' => ['superadmin','admin','manager'], 'children' => []],
            ['id' => 3, 'name' => 'Users', 'icon' => 'users', 'route' => '/users', 'order' => 3, 'enabled' => true, 'roles' => ['superadmin','admin','manager'],
                'children' => [
                    ['id' => 31, 'name' => 'All Users', 'route' => '/users', 'order' => 1, 'enabled' => true],
                    ['id' => 32, 'name' => 'Invite User', 'route' => '/users?action=invite', 'order' => 2, 'enabled' => true],
                ]
            ],
            ['id' => 4, 'name' => 'Roles & Permissions', 'icon' => 'shield-check', 'route' => '/roles', 'order' => 4, 'enabled' => true, 'roles' => ['superadmin','admin'],
                'children' => [
                    ['id' => 41, 'name' => 'Roles', 'route' => '/roles', 'order' => 1, 'enabled' => true],
                    ['id' => 42, 'name' => 'Permissions', 'route' => '/permissions', 'order' => 2, 'enabled' => true],
                ]
            ],
            ['id' => 5, 'name' => 'Reports', 'icon' => 'document-chart-bar', 'route' => '/reports', 'order' => 5, 'enabled' => true, 'roles' => ['superadmin','admin','manager','staff'], 'children' => []],
            ['id' => 6, 'name' => 'Activity Log', 'icon' => 'clock', 'route' => '/activity-log', 'order' => 6, 'enabled' => true, 'roles' => ['superadmin','admin','manager'], 'children' => []],
            ['id' => 7, 'name' => 'Notifications', 'icon' => 'bell', 'route' => '/notifications', 'order' => 7, 'enabled' => true, 'roles' => ['superadmin','admin','manager','staff','viewer'], 'children' => []],
            ['id' => 8, 'name' => 'Settings', 'icon' => 'cog-6-tooth', 'route' => '/settings', 'order' => 8, 'enabled' => true, 'roles' => ['superadmin','admin'], 'children' => []],
            ['id' => 9, 'name' => 'Help Center', 'icon' => 'question-mark-circle', 'route' => '/help', 'order' => 9, 'enabled' => true, 'roles' => ['superadmin','admin','manager','staff','viewer'], 'children' => []],
            ['id' => 10, 'name' => 'Legacy Module', 'icon' => 'archive-box', 'route' => '#', 'order' => 10, 'enabled' => false, 'roles' => ['superadmin'], 'children' => []],
        ];

        return view('pages.menu-management', $data);
    }

    // ──────────────────────────────────────────
    // ANALYTICS
    // ──────────────────────────────────────────

    public function analytics(Request $request)
    {
        $data = $this->commonData($request);

        $data['metrics'] = [
            ['label' => 'Page Views', 'value' => '1.2M', 'change' => '+18.2%', 'trend' => 'up'],
            ['label' => 'Unique Visitors', 'value' => '342K', 'change' => '+7.4%', 'trend' => 'up'],
            ['label' => 'Bounce Rate', 'value' => '32.1%', 'change' => '-2.3%', 'trend' => 'down'],
            ['label' => 'Avg. Session', 'value' => '4m 32s', 'change' => '+0.8%', 'trend' => 'up'],
        ];

        return view('pages.analytics', $data);
    }

    // ──────────────────────────────────────────
    // ACTIVITY LOG
    // ──────────────────────────────────────────

    public function activityLog(Request $request)
    {
        $data = $this->commonData($request);

        $data['activities'] = [
            ['id' => 1, 'user' => 'Sarah Wilson', 'initials' => 'SW', 'action' => 'Created', 'target' => 'New user account: john.doe@company.com', 'category' => 'user', 'ip' => '192.168.1.45', 'timestamp' => 'Mar 28, 2024 14:32:18', 'details' => 'User created via admin panel'],
            ['id' => 2, 'user' => 'Michael Chen', 'initials' => 'MC', 'action' => 'Updated', 'target' => 'Role permissions: Manager', 'category' => 'role', 'ip' => '192.168.1.102', 'timestamp' => 'Mar 28, 2024 14:15:03', 'details' => 'Added reports.export permission'],
            ['id' => 3, 'user' => 'System', 'initials' => 'SY', 'action' => 'Executed', 'target' => 'Scheduled backup: production-db', 'category' => 'system', 'ip' => '10.0.0.1', 'timestamp' => 'Mar 28, 2024 12:00:00', 'details' => 'Automated daily backup completed'],
            ['id' => 4, 'user' => 'Emily Davis', 'initials' => 'ED', 'action' => 'Deleted', 'target' => 'Inactive account: legacy_user_042', 'category' => 'user', 'ip' => '192.168.1.78', 'timestamp' => 'Mar 28, 2024 11:47:22', 'details' => 'Account inactive for 90+ days'],
            ['id' => 5, 'user' => 'James Rodriguez', 'initials' => 'JR', 'action' => 'Exported', 'target' => 'Q4 Financial Summary Report', 'category' => 'report', 'ip' => '192.168.1.33', 'timestamp' => 'Mar 28, 2024 10:22:11', 'details' => 'PDF format, 24 pages'],
            ['id' => 6, 'user' => 'Lisa Thompson', 'initials' => 'LT', 'action' => 'Modified', 'target' => 'System settings: Email notifications', 'category' => 'settings', 'ip' => '192.168.1.56', 'timestamp' => 'Mar 28, 2024 09:15:44', 'details' => 'Enabled digest mode'],
            ['id' => 7, 'user' => 'Amanda Lee', 'initials' => 'AL', 'action' => 'Login', 'target' => 'Admin panel access', 'category' => 'auth', 'ip' => '203.0.113.42', 'timestamp' => 'Mar 28, 2024 08:30:00', 'details' => '2FA verified'],
            ['id' => 8, 'user' => 'Robert Brown', 'initials' => 'RB', 'action' => 'Uploaded', 'target' => 'Document: company-policy-v3.pdf', 'category' => 'content', 'ip' => '192.168.1.91', 'timestamp' => 'Mar 27, 2024 16:45:33', 'details' => 'File size: 2.4 MB'],
        ];

        return view('pages.activity-log', $data);
    }

    // ──────────────────────────────────────────
    // NOTIFICATIONS
    // ──────────────────────────────────────────

    public function notifications(Request $request)
    {
        $data = $this->commonData($request);

        $data['allNotifications'] = [
            ['id' => 1, 'title' => 'New user registration', 'message' => 'John Doe (john.doe@company.com) has registered a new account and is awaiting approval.', 'time' => '5 min ago', 'read' => false, 'type' => 'info', 'category' => 'users'],
            ['id' => 2, 'title' => 'Server CPU alert', 'message' => 'Production server CPU usage has exceeded 85% threshold for the past 10 minutes.', 'time' => '12 min ago', 'read' => false, 'type' => 'warning', 'category' => 'system'],
            ['id' => 3, 'title' => 'Daily backup completed', 'message' => 'Automated daily backup for production database completed successfully. Size: 4.2 GB.', 'time' => '1 hour ago', 'read' => true, 'type' => 'success', 'category' => 'system'],
            ['id' => 4, 'title' => 'Invoice payment received', 'message' => 'Payment of $12,450 received for Invoice #INV-2024-0847 from Tech Solutions Inc.', 'time' => '2 hours ago', 'read' => false, 'type' => 'info', 'category' => 'billing'],
            ['id' => 5, 'title' => 'Unusual login attempt', 'message' => 'Multiple failed login attempts detected from IP 203.0.113.42 for user admin@company.com.', 'time' => '3 hours ago', 'read' => false, 'type' => 'danger', 'category' => 'security'],
            ['id' => 6, 'title' => 'Role permissions updated', 'message' => 'Manager role permissions have been modified by Super Admin. 2 permissions added.', 'time' => '5 hours ago', 'read' => true, 'type' => 'info', 'category' => 'roles'],
            ['id' => 7, 'title' => 'Report generated', 'message' => 'Q4 Financial Summary report has been generated and is ready for download.', 'time' => '6 hours ago', 'read' => true, 'type' => 'success', 'category' => 'reports'],
            ['id' => 8, 'title' => 'Scheduled maintenance', 'message' => 'System maintenance window scheduled for March 30, 2024 from 02:00 - 04:00 UTC.', 'time' => '1 day ago', 'read' => true, 'type' => 'warning', 'category' => 'system'],
        ];

        return view('pages.notifications', $data);
    }

    // ──────────────────────────────────────────
    // SETTINGS
    // ──────────────────────────────────────────

    public function settings(Request $request)
    {
        $data = $this->commonData($request);
        return view('pages.settings', $data);
    }

    // ──────────────────────────────────────────
    // PROFILE
    // ──────────────────────────────────────────

    public function profile(Request $request)
    {
        $data = $this->commonData($request);
        $data['profileData'] = [
            'name' => 'Andhika Pratama',
            'email' => 'andhika@company.com',
            'phone' => '+62 812-3456-7890',
            'department' => 'Technology',
            'position' => 'Senior Software Engineer',
            'location' => 'Jakarta, Indonesia',
            'timezone' => 'Asia/Jakarta (UTC+7)',
            'joinDate' => 'January 15, 2022',
            'bio' => 'Full-stack developer with 7+ years of experience in building scalable web applications. Passionate about clean architecture and user experience design.',
            'skills' => ['Laravel', 'Vue.js', 'React', 'TypeScript', 'PostgreSQL', 'Docker', 'AWS'],
        ];
        return view('pages.profile', $data);
    }

    // ──────────────────────────────────────────
    // REPORTS
    // ──────────────────────────────────────────

    public function reports(Request $request)
    {
        $data = $this->commonData($request);

        $data['reportsList'] = [
            ['id' => 1, 'name' => 'Monthly User Activity', 'description' => 'Comprehensive overview of user engagement metrics', 'type' => 'Analytics', 'lastGenerated' => 'Mar 28, 2024', 'size' => '2.4 MB', 'format' => 'PDF'],
            ['id' => 2, 'name' => 'Q4 Financial Summary', 'description' => 'Quarterly revenue and expense breakdown', 'type' => 'Finance', 'lastGenerated' => 'Mar 25, 2024', 'size' => '5.1 MB', 'format' => 'Excel'],
            ['id' => 3, 'name' => 'Security Audit Report', 'description' => 'System security assessment and vulnerability findings', 'type' => 'Security', 'lastGenerated' => 'Mar 20, 2024', 'size' => '1.8 MB', 'format' => 'PDF'],
            ['id' => 4, 'name' => 'User Growth Analysis', 'description' => 'Month-over-month user acquisition and retention', 'type' => 'Analytics', 'lastGenerated' => 'Mar 15, 2024', 'size' => '3.2 MB', 'format' => 'PDF'],
            ['id' => 5, 'name' => 'System Performance', 'description' => 'Server uptime, response times, and resource usage', 'type' => 'Technical', 'lastGenerated' => 'Mar 28, 2024', 'size' => '1.5 MB', 'format' => 'PDF'],
            ['id' => 6, 'name' => 'Department KPIs', 'description' => 'Key performance indicators across all departments', 'type' => 'Operations', 'lastGenerated' => 'Mar 22, 2024', 'size' => '4.7 MB', 'format' => 'Excel'],
        ];

        return view('pages.reports', $data);
    }

    // ──────────────────────────────────────────
    // HELP
    // ──────────────────────────────────────────

    public function help(Request $request)
    {
        $data = $this->commonData($request);

        $data['faqs'] = [
            ['question' => 'How do I reset my password?', 'answer' => 'Navigate to Settings > Security > Change Password. Enter your current password, then your new password twice. Click "Update Password" to save changes. If you\'ve forgotten your current password, use the "Forgot Password" link on the login page.'],
            ['question' => 'How do I manage user roles?', 'answer' => 'Go to the Roles page from the sidebar. Click on any role to view its permissions. Use the toggle switches to enable or disable specific permissions. You can also assign users to roles from the Users page by clicking the action menu on any user row.'],
            ['question' => 'Can I export data from the dashboard?', 'answer' => 'Yes, most tables and reports support data export. Look for the "Export" button in the top-right corner of any data table. You can export to CSV, Excel, or PDF formats depending on the report type.'],
            ['question' => 'How do I set up email notifications?', 'answer' => 'Visit Settings > Notifications to configure your email preferences. You can enable or disable notifications for different event types, and choose between instant or digest delivery modes. Make sure your email address is verified in your Profile settings.'],
            ['question' => 'What are the different user roles?', 'answer' => 'The system supports five role levels: Super Admin (full access), Admin (management access), Manager (team-level access), Staff (operational access), and Viewer (read-only access). Each role has specific permissions that control what features and actions are available.'],
            ['question' => 'How do activity logs work?', 'answer' => 'Activity logs automatically record all significant actions performed in the system. This includes user logins, data modifications, permission changes, and system events. Logs are retained for 90 days and can be filtered by user, action type, or date range.'],
        ];

        return view('pages.help', $data);
    }

    // ──────────────────────────────────────────
    // ERROR PAGES
    // ──────────────────────────────────────────

    public function error404()
    {
        return view('pages.errors.404');
    }

    public function maintenance()
    {
        return view('pages.errors.maintenance');
    }
}
