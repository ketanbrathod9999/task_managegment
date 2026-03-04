<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Task Management') }}
        </h2>
    </x-slot>

    <div class="py-12" x-data="taskManager()">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <!-- Error Alert -->
            <div x-show="errorMessage" x-transition class="mb-6 bg-red-50 border-l-4 border-red-500 p-4 rounded-lg shadow-md">
                <div class="flex items-start">
                    <svg class="w-6 h-6 text-red-500 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <div class="flex-1">
                        <h3 class="text-red-800 font-semibold mb-1">Validation Error</h3>
                        <p class="text-red-700 text-sm" x-text="errorMessage"></p>
                    </div>
                    <button @click="errorMessage = ''" class="text-red-500 hover:text-red-700 ml-4">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
            </div>

            <!-- Success Alert -->
            <div x-show="successMessage" x-transition class="mb-6 bg-green-50 border-l-4 border-green-500 p-4 rounded-lg shadow-md">
                <div class="flex items-start">
                    <svg class="w-6 h-6 text-green-500 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <div class="flex-1">
                        <p class="text-green-700 font-medium" x-text="successMessage"></p>
                    </div>
                    <button @click="successMessage = ''" class="text-green-500 hover:text-green-700 ml-4">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
            </div>
            
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    
                    <!-- Create New Project -->
                    <div class="mb-6 bg-gradient-to-r from-green-50 to-emerald-50 rounded-lg p-6 border border-green-200">
                        <div class="flex items-center gap-3 mb-3">
                            <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 13h6m-3-3v6m-9 1V7a2 2 0 012-2h6l2 2h6a2 2 0 012 2v8a2 2 0 01-2 2H5a2 2 0 01-2-2z"></path>
                            </svg>
                            <h3 class="text-lg font-semibold text-gray-800">Create New Project</h3>
                        </div>
                        <div class="flex gap-3">
                            <input 
                                type="text" 
                                x-model="newProjectName"
                                @keyup.enter="createProject()"
                                placeholder="Enter project name..."
                                class="flex-1 rounded-lg border-gray-300 shadow-sm focus:border-green-500 focus:ring-2 focus:ring-green-500 text-base py-3 px-4"
                            >
                            <button 
                                @click="createProject()"
                                class="px-6 py-3 bg-green-600 text-white rounded-lg hover:bg-green-700 font-medium shadow-md hover:shadow-lg transition-all duration-200 flex items-center gap-2"
                            >
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                </svg>
                                Add Project
                            </button>
                        </div>
                    </div>

                    <!-- Create New Task -->
                    <div class="mb-8 bg-gradient-to-r from-purple-50 to-pink-50 rounded-lg p-6 border border-purple-200">
                        <div class="flex items-center gap-3 mb-3">
                            <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path>
                            </svg>
                            <h3 class="text-lg font-semibold text-gray-800">Create New Task</h3>
                        </div>
                        <div class="flex flex-col sm:flex-row gap-3">
                            <input 
                                type="text" 
                                x-model="newTaskName"
                                @keyup.enter="createTask()"
                                placeholder="Enter task name..."
                                class="flex-1 rounded-lg border-gray-300 shadow-sm focus:border-purple-500 focus:ring-2 focus:ring-purple-500 text-base py-3 px-4"
                            >
                            <select 
                                x-model="newTaskProject"
                                class="sm:w-48 rounded-lg border-gray-300 shadow-sm focus:border-purple-500 focus:ring-2 focus:ring-purple-500 text-base py-3 px-4"
                            >
                                <option value="">📌 No Project</option>
                                <template x-for="project in projects" :key="project.id">
                                    <option :value="project.id" x-text="'📁 ' + project.name"></option>
                                </template>
                            </select>
                            <button 
                                @click="createTask()"
                                class="px-6 py-3 bg-gradient-to-r from-purple-600 to-indigo-600 text-white rounded-lg hover:from-purple-700 hover:to-indigo-700 font-medium shadow-md hover:shadow-lg transition-all duration-200 flex items-center justify-center gap-2"
                            >
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                </svg>
                                Add Task
                            </button>
                        </div>
                    </div>

                    <!-- Filter by Project -->
                    <div class="mb-6 bg-gradient-to-r from-blue-50 to-indigo-50 rounded-lg p-6 border border-blue-200">
                        <div class="flex items-center gap-3 mb-3">
                            <svg class="w-6 h-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path>
                            </svg>
                            <h3 class="text-lg font-semibold text-gray-800">Filter by Project</h3>
                        </div>
                        <select 
                            id="project-filter" 
                            x-model="selectedProject" 
                            @change="loadTasks()"
                            class="w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500 text-base py-3 px-4"
                        >
                            <option value="all">📋 All Tasks</option>
                            <template x-for="project in projects" :key="project.id">
                                <option :value="project.id" x-text="'📁 ' + project.name"></option>
                            </template>
                        </select>
                    </div>

                    <!-- Tasks List -->
                    <div>
                        <div class="flex items-center gap-3 mb-4">
                            <svg class="w-6 h-6 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"></path>
                            </svg>
                            <h3 class="text-lg font-semibold text-gray-800">Your Tasks</h3>
                            <span class="ml-auto text-sm text-gray-500 bg-gray-100 px-3 py-1 rounded-full" x-text="tasks.length + ' task' + (tasks.length !== 1 ? 's' : '')"></span>
                        </div>
                        
                        <div class="space-y-3">
                            <template x-for="(task, index) in tasks" :key="task.id">
                                <div 
                                    :data-task-id="task.id"
                                    draggable="true"
                                    @dragstart="dragStart($event, index)"
                                    @dragover.prevent="dragOver($event, index)"
                                    @drop="drop($event, index)"
                                    @dragend="dragEnd()"
                                    class="flex items-center gap-4 p-5 bg-white rounded-xl border-2 border-gray-200 cursor-move hover:border-indigo-300 hover:shadow-lg transition-all duration-200"
                                    :class="{ 'opacity-50 scale-95': draggingIndex === index, 'shadow-md': draggingIndex !== index }"
                                >
                                    <div class="flex-shrink-0 w-12 h-12 bg-gradient-to-br from-indigo-500 to-purple-600 text-white rounded-xl flex items-center justify-center font-bold text-lg shadow-md">
                                        <span x-text="task.priority"></span>
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <template x-if="editingTaskId === task.id">
                                            <input 
                                                type="text" 
                                                x-model="editingTaskName"
                                                @keyup.enter="saveTask(task)"
                                                @keyup.escape="cancelEdit()"
                                                class="w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500 text-base py-2 px-3"
                                            >
                                        </template>
                                        <template x-if="editingTaskId !== task.id">
                                            <div>
                                                <span class="font-semibold text-gray-800 text-lg" x-text="task.name"></span>
                                                <span x-show="task.project" class="ml-3 text-sm text-indigo-600 bg-indigo-50 px-3 py-1 rounded-full inline-flex items-center gap-1">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z"></path>
                                                    </svg>
                                                    <span x-text="task.project?.name"></span>
                                                </span>
                                            </div>
                                        </template>
                                    </div>
                                    <div class="flex gap-2 flex-shrink-0">
                                        <template x-if="editingTaskId === task.id">
                                            <div class="flex gap-2">
                                                <button 
                                                    @click="saveTask(task)"
                                                    class="px-4 py-2 bg-green-600 text-white text-sm rounded-lg hover:bg-green-700 font-medium shadow-sm hover:shadow-md transition-all duration-200 flex items-center gap-1"
                                                >
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                                    </svg>
                                                    Save
                                                </button>
                                                <button 
                                                    @click="cancelEdit()"
                                                    class="px-4 py-2 bg-gray-500 text-white text-sm rounded-lg hover:bg-gray-600 font-medium shadow-sm hover:shadow-md transition-all duration-200 flex items-center gap-1"
                                                >
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                                    </svg>
                                                    Cancel
                                                </button>
                                            </div>
                                        </template>
                                        <template x-if="editingTaskId !== task.id">
                                            <div class="flex gap-2">
                                                <button 
                                                    @click="editTask(task)"
                                                    class="px-4 py-2 bg-blue-600 text-white text-sm rounded-lg hover:bg-blue-700 font-medium shadow-sm hover:shadow-md transition-all duration-200 flex items-center gap-1"
                                                >
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                                    </svg>
                                                    Edit
                                                </button>
                                                <button 
                                                    @click="deleteTask(task.id)"
                                                    class="px-4 py-2 bg-red-600 text-white text-sm rounded-lg hover:bg-red-700 font-medium shadow-sm hover:shadow-md transition-all duration-200 flex items-center gap-1"
                                                >
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                    </svg>
                                                    Delete
                                                </button>
                                            </div>
                                        </template>
                                    </div>
                                </div>
                            </template>
                            
                            <div x-show="tasks.length === 0" class="text-center py-16">
                                <svg class="w-24 h-24 mx-auto text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                                </svg>
                                <p class="text-gray-500 text-lg font-medium mb-2">No tasks yet</p>
                                <p class="text-gray-400">Create your first task above to get started!</p>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <script>
        function taskManager() {
            return {
                tasks: [],
                projects: [],
                selectedProject: 'all',
                newTaskName: '',
                newTaskProject: '',
                newProjectName: '',
                editingTaskId: null,
                editingTaskName: '',
                draggingIndex: null,
                errorMessage: '',
                successMessage: '',

                async init() {
                    await this.loadProjects();
                    await this.loadTasks();
                },

                showError(message) {
                    this.errorMessage = message;
                    setTimeout(() => this.errorMessage = '', 5000);
                },

                showSuccess(message) {
                    this.successMessage = message;
                    setTimeout(() => this.successMessage = '', 3000);
                },

                async loadProjects() {
                    try {
                        const response = await fetch('/api/projects', {
                            headers: {
                                'Accept': 'application/json'
                            }
                        });
                        if (!response.ok) throw new Error('Failed to load projects');
                        this.projects = await response.json();
                    } catch (error) {
                        this.showError('Failed to load projects. Please refresh the page.');
                    }
                },

                async loadTasks() {
                    try {
                        const url = this.selectedProject === 'all' 
                            ? '/api/tasks' 
                            : `/api/tasks?project_id=${this.selectedProject}`;
                        const response = await fetch(url, {
                            headers: {
                                'Accept': 'application/json'
                            }
                        });
                        if (!response.ok) throw new Error('Failed to load tasks');
                        this.tasks = await response.json();
                    } catch (error) {
                        this.showError('Failed to load tasks. Please refresh the page.');
                    }
                },

                async createProject() {
                    if (!this.newProjectName.trim()) {
                        this.showError('Project name is required.');
                        return;
                    }

                    try {
                        const response = await fetch('/api/projects', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'Accept': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                            },
                            body: JSON.stringify({ name: this.newProjectName })
                        });

                        // Check if response is JSON
                        const contentType = response.headers.get('content-type');
                        if (!contentType || !contentType.includes('application/json')) {
                            throw new Error('Server error. Please check your connection and try again.');
                        }

                        const data = await response.json();

                        if (!response.ok) {
                            // Handle Laravel validation errors
                            if (data.errors) {
                                const errorMessages = Object.values(data.errors).flat();
                                throw new Error(errorMessages.join(' '));
                            }
                            throw new Error(data.message || 'Failed to create project');
                        }

                        this.newProjectName = '';
                        await this.loadProjects();
                        this.showSuccess('Project created successfully!');
                    } catch (error) {
                        this.showError(error.message || 'Failed to create project. Please try again.');
                    }
                },

                async createTask() {
                    if (!this.newTaskName.trim()) {
                        this.showError('Task name is required.');
                        return;
                    }

                    try {
                        const response = await fetch('/api/tasks', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'Accept': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                            },
                            body: JSON.stringify({ 
                                name: this.newTaskName,
                                project_id: this.newTaskProject || null
                            })
                        });

                        // Check if response is JSON
                        const contentType = response.headers.get('content-type');
                        if (!contentType || !contentType.includes('application/json')) {
                            throw new Error('Server error. Please check your connection and try again.');
                        }

                        const data = await response.json();

                        if (!response.ok) {
                            // Handle Laravel validation errors
                            if (data.errors) {
                                const errorMessages = Object.values(data.errors).flat();
                                throw new Error(errorMessages.join(' '));
                            }
                            throw new Error(data.message || 'Failed to create task');
                        }

                        this.newTaskName = '';
                        this.newTaskProject = '';
                        await this.loadTasks();
                        this.showSuccess('Task created successfully!');
                    } catch (error) {
                        this.showError(error.message || 'Failed to create task. Please try again.');
                    }
                },

                editTask(task) {
                    this.editingTaskId = task.id;
                    this.editingTaskName = task.name;
                },

                cancelEdit() {
                    this.editingTaskId = null;
                    this.editingTaskName = '';
                },

                async saveTask(task) {
                    if (!this.editingTaskName.trim()) {
                        this.showError('Task name cannot be empty.');
                        return;
                    }

                    try {
                        const response = await fetch(`/api/tasks/${task.id}`, {
                            method: 'PUT',
                            headers: {
                                'Content-Type': 'application/json',
                                'Accept': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                            },
                            body: JSON.stringify({ 
                                name: this.editingTaskName,
                                project_id: task.project_id
                            })
                        });

                        // Check if response is JSON
                        const contentType = response.headers.get('content-type');
                        if (!contentType || !contentType.includes('application/json')) {
                            throw new Error('Server error. Please check your connection and try again.');
                        }

                        const data = await response.json();

                        if (!response.ok) {
                            // Handle Laravel validation errors
                            if (data.errors) {
                                const errorMessages = Object.values(data.errors).flat();
                                throw new Error(errorMessages.join(' '));
                            }
                            throw new Error(data.message || 'Failed to update task');
                        }

                        this.editingTaskId = null;
                        this.editingTaskName = '';
                        await this.loadTasks();
                        this.showSuccess('Task updated successfully!');
                    } catch (error) {
                        this.showError(error.message || 'Failed to update task. Please try again.');
                    }
                },

                async deleteTask(taskId) {
                    if (!confirm('Are you sure you want to delete this task?')) return;

                    try {
                        const response = await fetch(`/api/tasks/${taskId}`, {
                            method: 'DELETE',
                            headers: {
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                            }
                        });

                        if (!response.ok) {
                            const data = await response.json().catch(() => ({}));
                            if (data.errors) {
                                const errorMessages = Object.values(data.errors).flat();
                                throw new Error(errorMessages.join(' '));
                            }
                            throw new Error(data.message || 'Failed to delete task');
                        }

                        await this.loadTasks();
                        this.showSuccess('Task deleted successfully!');
                    } catch (error) {
                        this.showError(error.message || 'Failed to delete task. Please try again.');
                    }
                },

                dragStart(event, index) {
                    this.draggingIndex = index;
                    event.dataTransfer.effectAllowed = 'move';
                },

                dragOver(event, index) {
                    event.preventDefault();
                    event.dataTransfer.dropEffect = 'move';
                },

                async drop(event, dropIndex) {
                    event.preventDefault();
                    
                    if (this.draggingIndex === null || this.draggingIndex === dropIndex) return;

                    try {
                        const draggedTask = this.tasks[this.draggingIndex];
                        this.tasks.splice(this.draggingIndex, 1);
                        this.tasks.splice(dropIndex, 0, draggedTask);

                        const reorderedTasks = this.tasks.map((task, index) => ({
                            id: task.id,
                            priority: index + 1
                        }));

                        const response = await fetch('/api/tasks/reorder', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                            },
                            body: JSON.stringify({ tasks: reorderedTasks })
                        });

                        const data = await response.json().catch(() => ({}));

                        if (!response.ok) {
                            // Handle Laravel validation errors
                            if (data.errors) {
                                const errorMessages = Object.values(data.errors).flat();
                                throw new Error(errorMessages.join(' '));
                            }
                            throw new Error(data.message || 'Failed to reorder tasks');
                        }

                        await this.loadTasks();
                        this.showSuccess('Tasks reordered successfully!');
                    } catch (error) {
                        this.showError(error.message || 'Failed to reorder tasks. Please try again.');
                        await this.loadTasks(); // Reload to reset order
                    }
                },

                dragEnd() {
                    this.draggingIndex = null;
                }
            }
        }
    </script>
</x-app-layout>
