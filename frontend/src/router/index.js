import { createRouter, createWebHistory } from 'vue-router'
import HomeView from '../views/HomeView.vue'
import ToDoView from '../views/ToDo/View.vue'
import ToDoCreate from '../views/ToDo/Create.vue'
import ToDoEdit from '../views/ToDo/Edit.vue'

const router = createRouter({
	history: createWebHistory(import.meta.env.BASE_URL),
	routes: [
		{
			path: '/',
			name: 'home',
			component: ToDoView
		},
		{
			path: '/about',
			name: 'about',
			// route level code-splitting
			// this generates a separate chunk (About.[hash].js) for this route
			// which is lazy-loaded when the route is visited.
			component: () => import('../views/AboutView.vue')
		},
		// {
		// 	path: '/to-do',
		// 	name: 'toDo',
		// 	component: ToDoView
		// },
		{
			path: '/to-do/create',
			name: 'toDoCreate',
			component: ToDoCreate
		},
		{
			path: '/to-do/:id/edit',
			name: 'toDoEdit',
			component: ToDoEdit
		}
	]
})

export default router
