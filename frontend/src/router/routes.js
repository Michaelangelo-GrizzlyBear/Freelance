const routes = [
  {
    path: '/',
    component: () => import('layouts/Home.vue')
  },
  {
    path: '/login', name: 'Login', component: () => import('pages/Login.vue'),

    meta: {
      auth: false
    }
  },
  {
    path: '/register', component: () => import('pages/Register.vue'),
    meta: {
      auth: false
    }
  },
  {
    path: '/superadmin',
    component: () => import('layouts/SuperAdminLayout.vue'),
    children: [
      { path: '/superadmin', name: 'HomeSuperAdmin', component: () => import('pages/superadmin/HomeSuperAdmin.vue') },
      { path: '/schedules', name: 'Schedule', component: () => import('pages/superadmin/Schedules.vue') },
      { path: '/doctors', name: 'AdminDoctors', component: () => import('pages/superadmin/Doctors.vue') },
      { path: '/items', name: 'Items', component: () => import('pages/superadmin/Items.vue') },
      { path: '/packageitem', name: 'PackageItem', component: () => import('pages/superadmin/PackageItem.vue') },
    ]
  },
  {
    path: '/admin',
    component: () => import('layouts/AdminLayout.vue'),
    children: [
      { path: '', name: 'HomeAdmin', component: () => import('pages/admin/HomeAdmin.vue') }
    ],
  },
  {
    path: '/patient',
    component: () => import('layouts/Patient.vue'),
    children: [
      { path: '/', name: 'HomePatient', component: () => import('pages/patient/Home.vue') },
      { path: '/patient/labtestprep', name: 'LabTestPrep', component: () => import('pages/patient/LabTestPreparation.vue') },
      { path: '/patient/doctors', name: 'Doctors', component: () => import('pages/patient/Doctors.vue') },
      { path: '/profile', name: 'Profile', component: () => import('pages/patient/Profile.vue') },
      { path: '/appointment', name: 'Appointment', component: () => import('pages/patient/Appointment.vue') },
    ],
  },
  {
    path: '/medtech',
    component: () => import('layouts/MedtechLayout.vue'),
    children: [
      { path: '', name: 'HomeMedTech', component: () => import('pages/medtech/index.vue') }
    ]
  },
  {
    path: '/supervisor',
    component: () => import('layouts/SupervisorLayout.vue'),
    children: [
      { path: '', name: 'HomeSupervisor', component: () => import('pages/supervisor/index.vue') }
    ]
  },
  {
    path: '*',
    component: () => import('pages/Error404.vue')
  },

]

export default routes
