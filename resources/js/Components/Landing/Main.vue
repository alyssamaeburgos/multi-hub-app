<template>
    <main>
        <section class="bg-white dark:bg-gray-900">
            <div
                class="py-8 px-4 mx-auto max-w-screen-xl text-center lg:py-16 mt-8"
            >
                <h1
                    class="mb-4 text-4xl font-extrabold tracking-tight leading-none text-gray-900 md:text-5xl lg:text-6xl dark:text-white"
                >
                    Multi-Hub: A Comprehensive Web Application for Productivity
                    and Content Management
                </h1>
                <p
                    class="mb-8 text-lg font-normal text-gray-500 lg:text-xl sm:px-16 lg:px-48 dark:text-gray-400"
                >
                    Develop a multi-feature web application with authentication,
                    task management, blogging, note-taking, weather updates, URL
                    shortener, and an e-library system.
                </p>
                <div
                    class="flex flex-col space-y-4 sm:flex-row sm:justify-center sm:space-y-0"
                >
                    <a
                        href="#"
                        class="inline-flex justify-center items-center py-3 px-5 text-base font-medium text-center text-white rounded-lg bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 dark:focus:ring-blue-900"
                    >
                        Get started
                        <svg
                            class="w-3.5 h-3.5 ms-2 rtl:rotate-180"
                            aria-hidden="true"
                            xmlns="http://www.w3.org/2000/svg"
                            fill="none"
                            viewBox="0 0 14 10"
                        >
                            <path
                                stroke="currentColor"
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M1 5h12m0 0L9 1m4 4L9 9"
                            />
                        </svg>
                    </a>
                    <a
                        href="#"
                        class="py-3 px-5 sm:ms-4 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700"
                    >
                        Learn more
                    </a>
                </div>
            </div>
        </section>
        <section>
            <div
                id="default-carousel"
                class="relative w-full mb-16 mt-8"
                data-carousel="slide"
            >
                <!-- Carousel wrapper -->
                <div class="relative h-56 overflow-hidden rounded-lg md:h-96">
                    <!-- Item 1 -->
                    <div
                        class="hidden duration-700 ease-in-out"
                        data-carousel-item
                    >
                        <img
                            src="/docs/images/carousel/carousel-1.svg"
                            class="absolute block w-full -translate-x-1/2 -translate-y-1/2 top-1/2 left-1/2"
                            alt="..."
                        />
                    </div>
                    <!-- Item 2 -->
                    <div
                        class="hidden duration-700 ease-in-out"
                        data-carousel-item
                    >
                        <img
                            src="/docs/images/carousel/carousel-2.svg"
                            class="absolute block w-full -translate-x-1/2 -translate-y-1/2 top-1/2 left-1/2"
                            alt="..."
                        />
                    </div>
                    <!-- Item 3 -->
                    <div
                        class="hidden duration-700 ease-in-out"
                        data-carousel-item
                    >
                        <img
                            src="/docs/images/carousel/carousel-3.svg"
                            class="absolute block w-full -translate-x-1/2 -translate-y-1/2 top-1/2 left-1/2"
                            alt="..."
                        />
                    </div>
                    <!-- Item 4 -->
                    <div
                        class="hidden duration-700 ease-in-out"
                        data-carousel-item
                    >
                        <img
                            src="/docs/images/carousel/carousel-4.svg"
                            class="absolute block w-full -translate-x-1/2 -translate-y-1/2 top-1/2 left-1/2"
                            alt="..."
                        />
                    </div>
                    <!-- Item 5 -->
                    <div
                        class="hidden duration-700 ease-in-out"
                        data-carousel-item
                    >
                        <img
                            src="/docs/images/carousel/carousel-5.svg"
                            class="absolute block w-full -translate-x-1/2 -translate-y-1/2 top-1/2 left-1/2"
                            alt="..."
                        />
                    </div>
                </div>
                <!-- Slider indicators -->
                <div
                    class="absolute z-30 flex -translate-x-1/2 bottom-5 left-1/2 space-x-3 rtl:space-x-reverse"
                >
                    <button
                        type="button"
                        class="w-3 h-3 rounded-full"
                        aria-current="true"
                        aria-label="Slide 1"
                        data-carousel-slide-to="0"
                    ></button>
                    <button
                        type="button"
                        class="w-3 h-3 rounded-full"
                        aria-current="false"
                        aria-label="Slide 2"
                        data-carousel-slide-to="1"
                    ></button>
                    <button
                        type="button"
                        class="w-3 h-3 rounded-full"
                        aria-current="false"
                        aria-label="Slide 3"
                        data-carousel-slide-to="2"
                    ></button>
                    <button
                        type="button"
                        class="w-3 h-3 rounded-full"
                        aria-current="false"
                        aria-label="Slide 4"
                        data-carousel-slide-to="3"
                    ></button>
                    <button
                        type="button"
                        class="w-3 h-3 rounded-full"
                        aria-current="false"
                        aria-label="Slide 5"
                        data-carousel-slide-to="4"
                    ></button>
                </div>
                <!-- Slider controls -->
                <button
                    type="button"
                    class="absolute top-0 start-0 z-30 flex items-center justify-center h-full px-4 cursor-pointer group focus:outline-none"
                    data-carousel-prev
                >
                    <span
                        class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-white/30 dark:bg-gray-800/30 group-hover:bg-white/50 dark:group-hover:bg-gray-800/60 group-focus:ring-4 group-focus:ring-white dark:group-focus:ring-gray-800/70 group-focus:outline-none"
                    >
                        <svg
                            class="w-4 h-4 text-white dark:text-gray-800 rtl:rotate-180"
                            aria-hidden="true"
                            xmlns="http://www.w3.org/2000/svg"
                            fill="none"
                            viewBox="0 0 6 10"
                        >
                            <path
                                stroke="currentColor"
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M5 1 1 5l4 4"
                            />
                        </svg>
                        <span class="sr-only">Previous</span>
                    </span>
                </button>
                <button
                    type="button"
                    class="absolute top-0 end-0 z-30 flex items-center justify-center h-full px-4 cursor-pointer group focus:outline-none"
                    data-carousel-next
                >
                    <span
                        class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-white/30 dark:bg-gray-800/30 group-hover:bg-white/50 dark:group-hover:bg-gray-800/60 group-focus:ring-4 group-focus:ring-white dark:group-focus:ring-gray-800/70 group-focus:outline-none"
                    >
                        <svg
                            class="w-4 h-4 text-white dark:text-gray-800 rtl:rotate-180"
                            aria-hidden="true"
                            xmlns="http://www.w3.org/2000/svg"
                            fill="none"
                            viewBox="0 0 6 10"
                        >
                            <path
                                stroke="currentColor"
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="m1 9 4-4-4-4"
                            />
                        </svg>
                        <span class="sr-only">Next</span>
                    </span>
                </button>
            </div>
        </section>

        <section>
            <div class="flex space-x-4 justify-center mb-8 mt-8">
                <div
                    class="max-w-sm bg-white border border-gray-200 rounded-lg shadow-sm dark:bg-gray-800 dark:border-gray-700"
                >
                    <a href="#">
                        <img
                            class="rounded-t-lg"
                            src="/docs/images/blog/image-1.jpg"
                            alt=""
                        />
                    </a>
                    <div class="p-5">
                        <a href="#">
                            <h5
                                class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white"
                            >
                                Library
                            </h5>
                        </a>
                        <p
                            class="mb-3 font-normal text-gray-700 dark:text-gray-400"
                        >
                            <span class="font-bold">Description:</span>
                            A digital library management system where users can
                            browse, search, and borrow books. Admins can manage
                            inventory, add new books, and track borrowing
                            history. <br /><br />
                            <span class="font-bold">Features:</span> CRUD
                            operations for books, user authentication and roles,
                            search and filter functionality, borrowing
                            management.
                        </p>
                        <a
                            href="#"
                            class="inline-flex items-center px-3 py-2 text-sm font-medium text-center text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800"
                        >
                            Read more
                            <svg
                                class="rtl:rotate-180 w-3.5 h-3.5 ms-2"
                                aria-hidden="true"
                                xmlns="http://www.w3.org/2000/svg"
                                fill="none"
                                viewBox="0 0 14 10"
                            >
                                <path
                                    stroke="currentColor"
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M1 5h12m0 0L9 1m4 4L9 9"
                                />
                            </svg>
                        </a>
                    </div>
                </div>

                <div
                    class="max-w-sm bg-white border border-gray-200 rounded-lg shadow-sm dark:bg-gray-800 dark:border-gray-700"
                >
                    <a href="#">
                        <img
                            class="rounded-t-lg"
                            src="/docs/images/blog/image-1.jpg"
                            alt=""
                        />
                    </a>
                    <div class="p-5">
                        <a href="#">
                            <h5
                                class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white"
                            >
                                Blog
                            </h5>
                        </a>
                        <p
                            class="mb-3 font-normal text-gray-700 dark:text-gray-400"
                        >
                            <span class="font-bold">Description:</span> A
                            platform for creating and sharing articles or posts.
                            Users can write, edit, and publish posts. Includes
                            categories, tags, and commenting functionality.
                            <br /><br />
                            <span class="font-bold">Features:</span> User
                            authentication, post CRUD operations, categories and
                            tags for organizing posts, commenting system, rich
                            text editor.
                        </p>
                        <a
                            href="#"
                            class="inline-flex items-center px-3 py-2 text-sm font-medium text-center text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800"
                        >
                            Read more
                            <svg
                                class="rtl:rotate-180 w-3.5 h-3.5 ms-2"
                                aria-hidden="true"
                                xmlns="http://www.w3.org/2000/svg"
                                fill="none"
                                viewBox="0 0 14 10"
                            >
                                <path
                                    stroke="currentColor"
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M1 5h12m0 0L9 1m4 4L9 9"
                                />
                            </svg>
                        </a>
                    </div>
                </div>

                <div
                    class="max-w-sm bg-white border border-gray-200 rounded-lg shadow-sm dark:bg-gray-800 dark:border-gray-700"
                >
                    <a href="#">
                        <img
                            class="rounded-t-lg"
                            src="/docs/images/blog/image-1.jpg"
                            alt=""
                        />
                    </a>
                    <div class="p-5">
                        <a href="#">
                            <h5
                                class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white"
                            >
                                Note-Taking App
                            </h5>
                        </a>
                        <p
                            class="mb-3 font-normal text-gray-700 dark:text-gray-400"
                        >
                            <span class="font-bold">Description:</span> An
                            application for creating and organizing personal or
                            collaborative notes. Users can create, edit, and
                            organize notes into categories or notebooks.
                            <br /><br />
                            <span class="font-bold">Features:</span> User
                            authentication, note CRUD operations, categorization
                            (notebooks/tags), real-time collaboration
                            (optional), markdown support.
                        </p>
                        <a
                            href="#"
                            class="inline-flex items-center px-3 py-2 text-sm font-medium text-center text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800"
                        >
                            Read more
                            <svg
                                class="rtl:rotate-180 w-3.5 h-3.5 ms-2"
                                aria-hidden="true"
                                xmlns="http://www.w3.org/2000/svg"
                                fill="none"
                                viewBox="0 0 14 10"
                            >
                                <path
                                    stroke="currentColor"
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M1 5h12m0 0L9 1m4 4L9 9"
                                />
                            </svg>
                        </a>
                    </div>
                </div>
                <div
                    class="max-w-sm bg-white border border-gray-200 rounded-lg shadow-sm dark:bg-gray-800 dark:border-gray-700"
                >
                    <a href="#">
                        <img
                            class="rounded-t-lg"
                            src="/docs/images/blog/image-1.jpg"
                            alt=""
                        />
                    </a>
                    <div class="p-5">
                        <a href="#">
                            <h5
                                class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white"
                            >
                                Task Manager
                            </h5>
                        </a>
                        <p
                            class="mb-3 font-normal text-gray-700 dark:text-gray-400"
                        >
                            <span class="font-bold">Description:</span> A tool
                            for managing tasks and projects. Users can create
                            tasks, assign them to team members, set deadlines,
                            and track progress. <br /><br />
                            <span class="font-bold">Features:</span> User
                            authentication and roles, task CRUD operations, task
                            assignment and deadline setting, progress tracking
                            (e.g., Kanban board), notifications.
                        </p>
                        <a
                            href="#"
                            class="inline-flex items-center px-3 py-2 text-sm font-medium text-center text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800"
                        >
                            Read more
                            <svg
                                class="rtl:rotate-180 w-3.5 h-3.5 ms-2"
                                aria-hidden="true"
                                xmlns="http://www.w3.org/2000/svg"
                                fill="none"
                                viewBox="0 0 14 10"
                            >
                                <path
                                    stroke="currentColor"
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M1 5h12m0 0L9 1m4 4L9 9"
                                />
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
        </section>
    </main>
</template>
