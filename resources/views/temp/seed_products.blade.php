@extends ("layouts/app")
@section ("title", "Seed products")

@section ("main")

    <script>

        async function seed_products() {
            const form_data = new FormData();
            form_data.append('products', JSON.stringify(products));

            await ajax('/api/seed_products', form_data);
        }

        const products = [];

        products.push({
            id: 1,
            name: "Project Management System - React, Laravel, Node.js, Java",
            slug: "project-management-system",
            price: 99,
            oldPrice: 0,
            startingCloud: 0,
            featuredImage: "project-management-tool/banner.png",
            images: [],
            categories: ["project", "management", "tool", "laravel", "php", "react", "nodejs"],
            description: "Internal tool for companies and individuals to manage their projects, tasks, timesheet, clients, finances, communication all in 1 place.",
            downloadLink: '/storage/demo/project-management-system-demo.zip',
            features: [
                "Dashboard",
                "Manage Projects",
                "Pin Projects",
                "Manage Tasks",
                "Kanban Board",
                "Assign Team Members to a Task",
                "Manage Clients",
                "Manage Team Members",
                "Group Chat",
                "Private Chat",
                "Time Tracker",
                "Auto-capture Screenshots",
                "File Manager",
                "Centralized Search",
                "Invoices",
                "Financial Ledger",
                "Secure Payments",
                "Multiple Currencies",
                "Soft Deletes",
                "Random Password Generator"
            ],
            sections: [
                {
                    title: "Demo",
                    description: "Manage your projects and tasks, and let your clients see the progress from your website. See how system works, how you can give clients access to their dashboard, how they can respond to the queries etc.<br /><br />You can create:<br /><ol><li>Team Members</li><li>Clients</li></ol>You can assign tasks to team members and your clients will be able to see the progress.</ol>",
                    type: "text_with_video",
                    url: "https://www.youtube.com/embed/ZBvgHKQsjtY"
                },
                {
                    title: "Private Chat",
                    description: "Sometimes you need to share sensitive information like cPanel credentials, that you do not want to share with other team members. You can do that by simply having a private chat with that member.<br /><br /><ol><li>Team members can have a chat between them.</li><li>Only admins can have a chat with clients.</li></ol>Users you recently had a chat will appear at the top. Chat is realtime, so you won't have to refresh the page to see new messages.",
                    type: "text_with_video",
                    url: "https://www.youtube.com/embed/ugBR-raVhwY"
                },
                {
                    title: "Invoices",
                    description: "Let your clients pay you directly from your own website via invoices.<br /><br />Just follow the steps:<br /><br /><ol><li>You create an invoice and link it with your client account.</li><li>Client can login and see all the pending invoices.</li><li>Client can pay via Stripe.</li><li>For recurring payments, client's payment method is saved securely so they can make another payment without entering their card details again.</li></ol>",
                    type: "text_with_video",
                    url: "https://www.youtube.com/embed/vdioleU1OTc"
                },
                {
                    title: "Projects",
                    description: "You can create projects and assign the client to it. Once client login, he will be able to see all his projects and their updates. You can write complete description of the project under it.",
                    type: "text_with_image",
                    url: "/img/products/project-management-tool/project-detail.png"
                },
                {
                    title: "Tasks",
                    description: "In each project, you can create multiple tasks. Whenever client ask for a new feature or a change, create a task so you won't have to remember. This will also help you not miss anything from client.<br /><br />Each task has a flow <i>todo -> progress -> done</i>.<br /><br />You can assign multiple team members to a task (including yourself) so they can collaborate on 1 place. Client and admin will also be able to see what's going on in this task.",
                    type: "text_with_image",
                    url: "/img/products/project-management-tool/add-task.png"
                },
                {
                    title: "Chat With Your Clients",
                    description: "You can discuss everything related to that task on each task's page. So all the communication related to that task stays under it, organized.<br /><br />You can send messages, attach documents, images, videos, you can send voice notes. You can mention a user to gain his attention to your message.",
                    type: "text_with_image",
                    url: "/img/products/project-management-tool/send-message.png"
                },
                {
                    title: "Documents",
                    description: "Whenever client sends a requirement document, you can attach it to your project so you can stick to the deliverables. You can add all associated documents, images, and videos of a project on it's page. So documents are not scattered, but are organized under each project. You can either view the files directly in the browser, or you can download them directly in your system.<br /><br />Only admin can delete the files, but they will be temporarily deleted. Only super admin can delete the files permanently.",
                    type: "text_with_image",
                    url: "/img/products/project-management-tool/file-manager.png"
                },
                {
                    title: "Typing...",
                    description: "When one person is typing a message, others will know. This is helpful because now you will know that the other person is replying to your message.",
                    type: "text_with_image",
                    url: "/img/products/project-management-tool/typing.png"
                },
                {
                    title: "Professional Dashboard",
                    description: "Each client has his own dashboard, from where he can see total number of projects he has with you. Total pending tasks, tasks you are currently working-on, and the tasks you have completed so far.<br /><br />As an admin, you can see:<ol><li>How many tasks you are getting per month.</li><li>How many projects you are getting each month.</li><li>Total number of users.</li><li>Latest tasks, you can click on them to simply open that task.</li><li>Same goes for latest projects and users.</li></ol><br />As they say, <i>Seeing your progress is a great way to boost it.</i>",
                    type: "text_with_image",
                    url: "/img/products/project-management-tool/dashboard.png"
                },
                {
                    title: "Invoices",
                    description: "Send invoices to your clients and they can pay directly on your website. You can filter invoices by their statuses, for example, <i>how many invoices are overdue?</i><br />As an admin, you can cancel any invoice and client won't be able to pay that one.<br /><br />You can invoice the client in his own currency, and you will be able to see:<br /><ol><li>Total Invoiced</li><li>Collected</li><li>Outstanding</li><li>Overdue</li></ol>for each currency.<br /><br />You can send friendly reminder to clients for overdue invoices.<br />Clients can see all the invoices issues to him from his dashboard.",
                    type: "text_with_image",
                    url: "/img/products/project-management-tool/invoices.png"
                },
                {
                    title: "Receive Payments",
                    description: "Clients do not have to go to third-party platforms to make you payment everytime. They can pay with their debit or credit card directly on your website and the amount will be reflected in your account.<br /><br />If you are running a business where you take payments from clients on each month, for example if you provide maintenance services, then your clients can simply visit your website and click their previously used payment method and it will automatically charge from it.",
                    type: "text_with_image",
                    url: "/img/products/project-management-tool/invoice-detail.png"
                },
                {
                    title: "Send Reminder for Invoices",
                    description: "Sometimes clients forget to make the payment on time. You can send them a friendly reminder directly from the system.",
                    type: "text_with_image",
                    url: "/img/products/project-management-tool/send-reminder.png"
                },
                {
                    title: "Financial Ledger",
                    description: "Track your expenses and income from your website. This feature is available for admins only so they can debit or credit the amount they are spending or receiving.<br /><br />You can add transactions in multiple currencies. You can filter the transactions by:<br /><ol><li>Currency</li><li>Category (general, tax, payroll etc.)</li><li>Date</li></ol>You can delete the transaction anytime and the stats will automatically gets updated.<br /><br />You can add additional notes with each transaction, so you will know why this transaction was made.",
                    type: "text_with_image",
                    url: "/img/products/project-management-tool/financial-ledger.png"
                },
                {
                    title: "Time Tracking",
                    description: "A time tracking app that you can use to see how many hours or minutes it took to do a specific task. It will be an executable file. Here is how it works:<br /><br /><ol><li>Login on app</li><li>Select the Project</li><li>Select the Task</li><li>Start the timer when starts working</li><li>Stop the timer once done</li></ol>",
                    type: "text_with_image",
                    url: "/img/products/project-management-tool/time-tracking-screen.png"
                },
                {
                    title: "Total Time Spent on a Task",
                    description: "You can see how many hours and minutes are spent on each task. This is helpful when you are billing the client on hourly basis. Your clients can also see the time you have worked on his tasks.",
                    type: "text_with_image",
                    url: "/img/products/project-management-tool/total-hours.png"
                },
                {
                    title: "Timer Sessions",
                    description: "While working on something, you might be taking breaks. So you can:<br /><br /><ol><li>Stop the timer</li><li>Take the break</li><li>Start again when you are refreshed</li></ol>So you can work in sessions and see for how long have you worked in each session.",
                    type: "text_with_image",
                    url: "/img/products/project-management-tool/timer-sessions.png"
                },
                {
                    title: "Screenshots",
                    description: "The timer app will automatically takes screenshots on random interval of time. You can see all screenshots from your task detail page.<br /><br /><ul><li>This is a great way to get focused on the work.</li><li>Because you will get a feeling that someone is watching you if you are doing the real work or doing something else.</li></ul>",
                    type: "text_with_image",
                    url: "/img/products/project-management-tool/screenshots.png"
                },
                {
                    title: "Search Everything",
                    description: "Instead of having search on each page, we have 1 centralized search that can search everything. You can search:<br /><br /><ul><li>Projects</li><li>Tasks</li><li>Chat Messages</li></ul>All from 1 place.",
                    type: "text_with_image",
                    url: "/img/products/project-management-tool/search-everything.png"
                },
            ],
            /*
            pricings: [
                {
                    title: "Basic",
                    price: "$9",
                    duration: "/month",
                    features: [
                        "10 Users",
                        "10 Projects",
                        "Email Support",
                        "1 GB Storage",
                        "Custom Domain Support"
                    ],
                    buttonText: "Start Now",
                    buttonClass: "btn-outline-dark",
                },
                {
                    title: "Growth",
                    price: "$19",
                    duration: "/month",
                    features: [
                        "100 Users",
                        "100 Projects",
                        "Email + WhatsApp Support",
                        "5 GB Storage",
                        "Custom Domain Support"
                    ],
                    buttonText: "Start Now",
                    buttonClass: "btn-outline-dark",
                },
                {
                    title: "Premium",
                    price: "$29",
                    duration: "/month",
                    features: [
                        "1000 Users",
                        "1000 Projects",
                        "Email + WhatsApp + Call Support",
                        "10 GB Storage",
                        "Custom Domain Support"
                    ],
                    buttonText: "Start Now",
                    buttonClass: "btn-outline-dark",
                },
                {
                    title: "Self-Hosted",
                    price: "",
                    duration: "Contact Support",
                    features: [
                        "Unlimited Users",
                        "Unlimited Projects",
                        "Basic Support",
                        "Unlimited Storage",
                        "Full Source Code"
                    ],
                    buttonText: "Contact Support",
                    buttonClass: "btn-dark",
                },
            ]
            */
        }, {
            name: "Doctor Appointment Booking System - Laravel",
            slug: "doctor-appointment-booking-laravel",
            price: 99,
            oldPrice: 0,
            featuredImage: "doctor-appointment-booking-laravel/banner.png",
            images: [],
            categories: ["laravel", "php", "mysql"],
            description: "",
            sections: [
                {
                    title: "Demo",
                    description: "Our video demo shows how effortless managing appointments can be. Saves your time, optimize your schedule, and improve patient satisfaction all with one simple platform.",
                    type: "text_with_video",
                    url: "https://www.youtube.com/embed/0WiDSwW06dI"
                },
                {
                    title: "Streamline Doctor Appointments",
                    description: "Manage patient bookings effortlessly with a modern Laravel system. Keep schedules organized, reduce no-shows, and provide a seamless experience for both doctors and patients.",
                    type: "text_with_image",
                    url: "/img/products/doctor-appointment-booking-laravel/appointment.png"
                },
                {
                    title: "Responsive Design",
                    description: "Looks great on desktop, tablet, and mobile out of the box.",
                    type: "text",
                },
                {
                    title: "Admin Dashboard",
                    description: "Manage patients, and appointments easily with a built-in dashboard.",
                    type: "text",
                },
                {
                    title: "Patient History & Records",
                    description: "Maintain complete and accurate medical records and appointment history for every patient.",
                    type: "text",
                    url: ""
                },
                {
                    title: "Doctor Chat",
                    description: "Patients can securely chat with doctors for quick consultations and follow-ups.",
                    type: "text",
                    url: ""
                },
            ]
        }, {
            name: "Job Portal - React + Laravel",
            slug: "job-portal-react-laravel",
            price: 99,
            oldPrice: 0,
            featuredImage: "job-portal-react-laravel/banner.png",
            images: [],
            categories: ["reactjs", "laravel", "php", "mysql"],
            description: "",
            sections: [
                {
                    title: "Demo",
                    description: "Watch our quick demo to see how our innovative, easy-to-use job portal makes hiring and job searching effortless. From posting jobs and managing applications to finding the best candidates or opportunities, the platform quickly and efficiently streamlines the entire process. See how it saves time, improves matching, and helps both employers and job seekers truly succeed.",
                    type: "text_with_video",
                    url: "https://www.youtube.com/embed/-vQqTH1FhRk"
                },
                {
                    title: "How to setup",
                    description: "See how easy it is to set up your job portal script. Simply download the files, upload them to your server, configure the basic settings, and start running your platform instantly, hassle-free.",
                    type: "text_with_video",
                    url: "https://www.youtube.com/embed/fQD5g-HJI04"
                },
                {
                    title: "Make money from this platform",
                    description: "Turn your job portal into a revenue-generating platform with ease. Monetize by charging employers for featured listings, thus creating a profitable, self-sustaining system.",
                    type: "text_with_video",
                    url: "https://www.youtube.com/embed/GSX6DYcytyo"
                },
                {
                    title: "Email Integration",
                    description: "Configured with SMTP for reliable email delivery and notifications.",
                    type: "text"
                },
                {
                    title: "Chat Integration",
                    description: "Includes chat widget for real-time customer communication.",
                    type: "text"
                },
                {
                    title: "Deployment Compatibility",
                    description: "Can be easily deployed on shared hosting, VPS, or dedicated servers.",
                    type: "text"
                }
            ]
        }, {
            name: "Multi-purpose platform in Node.js and MongoDB",
            slug: "multi-purpose-platform-nodejs-mongodb",
            price: 99,
            oldPrice: 0,
            featuredImage: "multi-purpose-platform-nodejs-mongodb/banner.jpg",
            images: [],
            categories: ["reactjs", "nodejs", "mongodb"],
            description: "",
            sections: [
                {
                    title: "Demo",
                    description: "This API saves development and testing time by 70%. You will get many APIs ready to use that you might have to develop and test otherwise.",
                    type: "text_with_video",
                    url: "https://www.youtube.com/embed/G8TCHUeisiA"
                },
                {
                    title: "Pages",
                    description: "If you are running a business, you can create a page for your business and start posting about your products or services in that page. In order to create a page, you need to set it’s name, tell a little about the page, and provide a cover photo for the page.",
                    type: "text_with_video",
                    url: "https://www.youtube.com/embed/vkMhB_yPcCY"
                },
                {
                    title: "Groups",
                    description: "You can create groups to create a community of like-minded people. In order to create a group, you need to enter the name of group, a little description about the group and it’s cover photo. Only admin or group members can post in a group. Posts uploaded by admin will be immediately displayed on the groups newsfeed. However, the posts uploaded by group members will be held pending for approval from the admin.",
                    type: "text_with_video",
                    url: "https://www.youtube.com/embed/_wprWr0CE4Q"
                },
                {
                    title: "End-to-end Encrypted (E2EE) Chat",
                    description: "You can have realtime chat with your friends. Chats are end-to-end encrypted, that means that the messages are encrypted before sending to the server. Messages are decrypted only after receiving the response from the server. Your messages will remain secure in-transit.",
                    type: "text_with_video",
                    url: "https://www.youtube.com/embed/wA0Ob2JwOME"
                },
                {
                    title: "Job Portal",
                    description: "A platform that allows recruiter to post jobs and candidates can apply on that job. Recruiter can see all the applications he has received on a job and can change the status of applicant to shortlisted, interviewing, rejected or selected etc. Candidate can upload multiple CVs and choose the relevant CV while applying for the job. Recruiter can update or delete the job any time.",
                    type: "text_with_video",
                    url: "https://www.youtube.com/embed/4AU_m5cBkKE"
                },
                {
                    title: "Admin Panel",
                    description: "Manage users, jobs, posts, and freelance gigs all from one place. Admin can add a new user if he wants. An email with password set by admin will be sent to the new user. Admin can also update the user password as well.",
                    type: "text_with_video",
                    url: "https://www.youtube.com/embed/kSaIFnOdC2E"
                },
                {
                    title: "Freelance Platform",
                    description: "There are 2 entities in freelance platform: Buyer and Seller. Buyer will create a task, mention his budget and deadline. Sellers will start bidding on that task. Buyer will see all the bids from sellers. Buyer can accept the bid of any seller he seems fit for the job. On their order detail page, they can chat with each other. After the work is done, buyer can complete the order. Once it is completed, the amount that was offered in the bid will be deducted from buyer’s account. 5 percent will be deducted as a platform fee, and the remaining 95% of the amount will be added in the seller's account.",
                    type: "text_with_video",
                    url: "https://www.youtube.com/embed/703s4d-QNzE"
                },
                {
                    title: "Blogs",
                    description: "Admin can write blogs and they will be displayed on user side. User can post a comment. Other users or admin can reply to their comments. Admin can delete any comment he did not find suitable.",
                    type: "text_with_video",
                    url: "https://www.youtube.com/embed/j1TupIgwyw8"
                },
                {
                    title: "Page Builder",
                    description: "Created a page builder similar to WordPress that helps to write blog posts in an easy way.",
                    type: "text_with_video",
                    url: "https://www.youtube.com/embed/WvIjvly7T7o"
                }
            ]
        }, {
            name: "File Manager in React + Laravel",
            slug: "file-manager-react-laravel",
            price: 99,
            oldPrice: 0,
            featuredImage: "file-manager-react-laravel/banner.png",
            images: [],
            categories: ["reactjs", "laravel", "php", "mysql"],
            description: "",
            sections: [
                {
                    title: "For Companies",
                    description: "You can deploy this on your own subdomain and all your employees can use this to share files above themselves.",
                    type: "text_with_video",
                    url: "https://www.youtube.com/embed/8DdkzDIINGk"
                },
                {
                    title: "Collaboration",
                    description: "If 2 employees are working on the same file, then the other can see the changes of 1st in real-time. No need to refresh the page to see changes.",
                    type: "text_with_video",
                    url: "https://www.youtube.com/embed/NWabtlFYUAQ"
                },
                {
                    title: "Soft Delete",
                    description: "Deleted files goes to the trash can where they can be easily recovered or permanently destroyed. This prevents accidental deletion of important files.",
                    type: "text_with_video",
                    url: "https://www.youtube.com/embed/LVieNyKeJtI"
                },
                {
                    title: "Contacts",
                    description: "You can save a user in your contact and whenever you want to share file to that contact, you can easily search that user by name or email. This makes sure that you are sending the file to the current person.",
                    type: "text_with_video",
                    url: "https://www.youtube.com/embed/jqvUcFA3odQ"
                }
            ]
        }, {
            name: "Trustpilot Clone - Laravel",
            slug: "trustpilot-clone-laravel",
            price: 99,
            oldPrice: 0,
            featuredImage: "trustpilot-clone-laravel/banner.png",
            images: [],
            categories: ["vue", "laravel", "php", "mysql"],
            description: "",
            sections: [
                {
                    title: "Trust but verify",
                    description: "Read what others are saying about a company before buying their product.",
                    type: "text_with_video",
                    url: "https://www.youtube.com/embed/UMYRliW5Lv4"
                },
                {
                    title: "Risk-score",
                    description: "View ratings of a company either it is good or bad.",
                    type: "text_with_video",
                    url: "https://www.youtube.com/embed/_aB2q-r_eHA"
                },
                {
                    title: "Widget",
                    description: "Allow companies to embed your widget in their website so they can show trust to their customers.",
                    type: "text_with_video",
                    url: "https://www.youtube.com/embed/Si-OTn-yfxk"
                },
                {
                    title: "Manage multiple devices",
                    description: "As a company, you can login from different devices but still can logout from any other device. This is useful when you no longer have access to that device.",
                    type: "text_with_video",
                    url: "https://www.youtube.com/embed/6I67MmSwuJg"
                },
                {
                    title: "Watch development process",
                    description: "No AI, no autocomplete features, just coding in it's real form.",
                    type: "text_with_video",
                    url: "https://www.youtube.com/embed/jp6zqwqOWEs"
                }
            ]
        }, {
            name: "Jobfinder - PHP MySQL MVC",
            slug: "jobfinder-php-mysql-mvc",
            price: 99,
            oldPrice: 0,
            featuredImage: "jobfinder-php-mysql-mvc/banner.png",
            images: [],
            categories: ["php", "mysql", "mvc"],
            description: "",
            sections: [
                {
                    title: "Demo",
                    description: "See how recruiters can post jobs and candidates can find them.",
                    type: "text_with_video",
                    url: "https://www.youtube.com/embed/cU7CkIWo8sU"
                },
                {
                    title: "Post a Job",
                    description: "Recruiter can post a job after creating their company account.",
                    type: "text_with_image",
                    url: "/img/products/jobfinder-php-mysql-mvc/Post-job.png"
                },
                {
                    title: "My posted jobs",
                    description: "As a recruiter, you can see all your posted jobs and can edit or delete them.",
                    type: "text_with_image",
                    url: "/img/products/jobfinder-php-mysql-mvc/Recruiter-uploaded-jobs.png"
                },
                {
                    title: "Job listing",
                    description: "Candidates can see a list of all jobs and they can filter out the jobs as per their skill set. They will automatically be notified when a new job is posted by any recruiter.",
                    type: "text_with_image",
                    url: "/img/products/jobfinder-php-mysql-mvc/Job-listing.png"
                },
                {
                    title: "Job detail",
                    description: "View job summary, number of vacancies, location, either it is on-site/remote/hybrid, salary range and the last date for to submit your application. Applicants list will only be displayed to recruiters. Candidates can turn-on notifications from a specific recruiter. So whenever that recruiter posts a new job, you will be notified.",
                    type: "text_with_image",
                    url: "/img/products/jobfinder-php-mysql-mvc/Job-detail.png"
                }
            ]
        }, {
            name: "Android Chat App - Kotlin, Node.js",
            slug: "android-chat-app-kotlin-nodejs",
            price: 99,
            oldPrice: 0,
            featuredImage: "android-chat-app-kotlin-nodejs/banner.png",
            images: [
                "android-chat-app-kotlin-nodejs/Welcome.png",
                "android-chat-app-kotlin-nodejs/Register.png",
                "android-chat-app-kotlin-nodejs/My-profile.png",
                "android-chat-app-kotlin-nodejs/Profile-updated.png",
                "android-chat-app-kotlin-nodejs/Permissions.png",
                "android-chat-app-kotlin-nodejs/Contacts-list.png",
                "android-chat-app-kotlin-nodejs/Chat-activity.png",
                "android-chat-app-kotlin-nodejs/create-group.png",
                "android-chat-app-kotlin-nodejs/Groups-list.png",
                "android-chat-app-kotlin-nodejs/Group-message.png",
                "android-chat-app-kotlin-nodejs/Share-status-or-story.png",
                "android-chat-app-kotlin-nodejs/Select-contacts-to-add-in-list.png",
            ],
            categories: ["android", "kotlin", "nodejs", "chat"],
            description: "",
            sections: [
                {
                    title: "For Companies",
                    description:
                        "If you do not want to use third-party services to chat about your internal company matters, you can deploy this in your own server. Your employees can install the mobile app on their devices and starts communicating. Data will remain on your company's server.",
                    type: "text_with_video",
                    url: "https://www.youtube.com/embed/VGcqgK-32Jw"
                },
                {
                    title: "For Private Chat",
                    description:
                        "Use this app to chat personally with any person. Just deploy the backend on your server (we will do that for you). You and other person can install the app and you both can chat privately. Data will never leave your server.",
                    type: "text_with_video",
                    url: "https://www.youtube.com/embed/eyDpaKPBIHA"
                },
                {
                    title: "For Families",
                    description:
                        "Deploy the app on your own server and your family members can install the app. Chats done there will remain private.",
                    type: "text_with_video",
                    url: "https://www.youtube.com/embed/EDae_BZuLo0"
                },
                {
                    title: "Status for 24 hours",
                    description:
                        "Give temporary updates to your contacts about yourself. Stories uploaded will be removed automatically after 24 hours.",
                    type: "text_with_video",
                    url: "https://www.youtube.com/embed/Nd0joODJ9vQ"
                },
                {
                    title: "Know if message was delivered",
                    description:
                        "With the help of tick mark, you will be able to see if your message is delivered to the recipient. This gives relaxation that the other person got the message you wanted to deliver.",
                    type: "text_with_video",
                    url: "https://www.youtube.com/embed/BaxAmGJTbnM"
                },
                {
                    title: "How you looked recently",
                    description:
                        "Change your profile picture regularly to keep your contacts know how you look after joining the gym.",
                    type: "text_with_video",
                    url: "https://www.youtube.com/embed/IY1IfwUQ2Rg"
                },
                {
                    title: "End-to-end encrypted (E2EE) messages",
                    description:
                        "With messages encrypted before sending to the server, no-one can read your chat even if your server got hacked or if your database was leaked.",
                    type: "text_with_video",
                    url: "https://www.youtube.com/embed/wfSR02tOiXo"
                },
                {
                    title: "Voice notes",
                    description:
                        "Sometimes you are in a hurry, or when you want to explain something complex, it's good to just speak it out than typing it.",
                    type: "text_with_video",
                    url: "https://www.youtube.com/embed/fVhWyxjJyDs"
                },
                {
                    title: "Search audio notes",
                    description:
                        "If you remember any of the word in the audio message, you can simply type it in search field and the app will show you only the audio messages that has the searched text in it.",
                    type: "text_with_video",
                    url: "https://www.youtube.com/embed/mOAEZTs5AlY"
                },
                {
                    title: "Search messages",
                    description:
                        "Find lost messages by simply typing any word you remember from entire message.",
                    type: "text_with_video",
                    url: "https://www.youtube.com/embed/h_BpFkWZfvY"
                },
                {
                    title: "Image search",
                    description:
                        "Instead of scrolling endlessly, you can search images inside chats by typing any text that appears in them. The app will find matching images instantly.",
                    type: "text_with_video",
                    url: "https://www.youtube.com/embed/aw-z7Dq7TuA"
                },
                {
                    title: "Scheduled messages",
                    description:
                        "Hold the send button to schedule messages for a specific date and time. You can manage all scheduled messages from the menu.",
                    type: "text_with_video",
                    url: "https://www.youtube.com/embed/mJ9HmIIJzzQ"
                }
            ]
        }, {
            name: "Ecommerce website in MEVN stack",
            slug: "ecommerce-mevn",
            price: 99,
            oldPrice: 0,
            featuredImage: "ecommerce-mevn/banner.png",
            images: [],
            categories: ["ecommerce", "mevn", "nodejs", "vuejs", "mongodb"],
            description: "",
            sections: [
                {
                    title: "Demo",
                    description:
                        "Launch your ecommerce store with a website that does not refresh. It just updates the components, creating a seamless user experience.",
                    type: "text_with_video",
                    url: "https://www.youtube.com/embed/YFO8b4XItc0"
                },
                {
                    title: "Advanced features",
                    description:
                        "Getting email on new order prevents missing any order. You can set different shipping charges based on customers's country. Ask customers to leave a review so it will create trust for future customers.",
                    type: "text_with_video",
                    url: "https://www.youtube.com/embed/MXwob7US3zs"
                },
                {
                    title: "Save space and time",
                    description:
                        "You can take high quality images from your camera. But with our loss-less image compression, you can make them take less space without losing the quality. If customer is taking too long to make a decision to buy a product, you can directly have a chat with him and remove his doubts.",
                    type: "text_with_video",
                    url: "https://www.youtube.com/embed/q7_117zID9E"
                },
                {
                    title: "Suitable for every country",
                    description:
                        "No matter which country you are living in, you can run your store in your own preferred currency.",
                    type: "text_with_video",
                    url: "https://www.youtube.com/embed/kpHz-Svo9fI"
                }
            ]
        }, {
            name: "Realtime chat app in MEVN stack - Single Page Application",
            slug: "realtime-chat-app-mevn-spa",
            price: 99,
            oldPrice: 0,
            featuredImage: "realtime-chat-app-mevn-spa/banner.png",
            images: [],
            categories: ["chat", "mevn", "nodejs", "vuejs", "mongodb"],
            description: "",
            sections: [
                 {
                    title: "Demo",
                    description: "Chat with your friends and family privately with end-to-end encryption.",
                    type: "text_with_video",
                    url: "https://www.youtube.com/embed/x4Maha4LVZg"
                },
                {
                    title: "Easy Deployment",
                    description: "With our guide, you can make your website live in 30 minutes.",
                    type: "text_with_video",
                    url: "https://www.youtube.com/embed/MBQ-Kxy0EIM"
                },
                {
                    title: "Put emotions in chat",
                    description: "Add emojis in your message to express your feelings. You can bookmark a message that is important.",
                    type: "text_with_video",
                    url: "https://www.youtube.com/embed/vJ9yIB5_oUM"
                },
                {
                    title: "Protect your chat",
                    description: "You can put a password on chat with specific user. So even if someone access your account, he won't be able to read the chat with that user.",
                    type: "text_with_video",
                    url: "https://www.youtube.com/embed/yzwx3baxJbk"
                }
            ]
        }, {
            name: "Picture Competition Website in MEVN stack",
            slug: "picture-competition-website-mevn",
            price: 99,
            oldPrice: 0,
            featuredImage: "picture-competition-website-mevn/banner.jpg",
            images: [],
            categories: ["mevn", "nodejs", "vuejs", "mongodb"],
            description: "",
            sections: [
                {
                    title: "Create Competitions",
                    description:
                        "Registered users can create competitions between 2 users. You can enter name and upload 1 picture of each competitor. There is no limit in the number of competitions to create, you can create as many as you want.",
                    type: "text",
                    url: ""
                },
                {
                    title: "Vote on Competition",
                    description:
                        "You can vote on one of the competitors in a competition. Once a vote is cast, it cannot be removed. You can only vote for one competitor, not both.",
                    type: "text",
                    url: ""
                },
                {
                    title: "Delete Competitions",
                    description:
                        "Competitions can only be deleted by either one of the users who created the competition or by the admin.",
                    type: "text",
                    url: ""
                },
                {
                    title: "Admin Panel",
                    description:
                        "The admin panel allows administrators to delete any competition. The admin must provide a reason for deletion, and a notification will be sent to the user who created that competition.\n\nDefault admin credentials:\nemail: admin@gmail.com\npassword: admin",
                    type: "text",
                    url: ""
                },
                {
                    title: "Adult Image Validation",
                    description:
                        "Users can upload images while creating competitions, but the system automatically checks if the image contains adult content. If an adult image is detected, an error is shown and the image will not be uploaded. This helps maintain platform safety and quality.",
                    type: "text",
                    url: ""
                },
                {
                    title: "Admin Panel Stats",
                    description:
                        "The admin can view total users, total competitions, and total votes cast on the platform.",
                    type: "text",
                    url: ""
                },
                {
                    title: "Free Customer Support",
                    description:
                        "This is a free service provided for the pro version only. If you face any difficulty installing or configuring the project, support will help you. Any bugs or errors in the released version can also be fixed.",
                    type: "text",
                    url: ""
                }
            ]
        }, {
            name: "Financial Ledger in Node.js and MongoDB",
            slug: "financial-ledger-nodejs-mongodb",
            price: 99,
            oldPrice: 0,
            featuredImage: "financial-ledger-nodejs-mongodb/banner.jpg",
            images: [],
            categories: ["finance", "nodejs", "vuejs", "mongodb"],
            description: "",
            sections: [
                {
                    title: "Demo",
                    description: "Track your daily expenses and income.",
                    type: "text_with_video",
                    url: "https://www.youtube.com/embed/Sm-PLd0S77Y"
                }
            ]
        }, {
            name: "Blog in Laravel with Android app",
            slug: "laravel-blog-with-android-app",
            price: 99,
            oldPrice: 0,
            featuredImage: "laravel-blog-with-android-app/banner.jpg",
            images: [],
            categories: ["laravel", "blog", "android", "java", "php", "mysql"],
            description: "",
            sections: [
                {
                    title: "Demo",
                    description: "Launch your blog with only the features you actually need.",
                    type: "text_with_video",
                    url: "https://www.youtube.com/embed/FLS1KhGPK_o"
                },
                {
                    title: "Android App",
                    description:
                        "A dedicated mobile app that helps you interact with your readers in a more personal manner.",
                    type: "text_with_video",
                    url: "https://www.youtube.com/embed/zin-Fbz0BIY"
                },
                {
                    title: "Google Adsense approved",
                    description:
                        "The project is tested with Google Adsense and Google AdMob and it was approved by Google for monetization. You just have to link with your Google account and you will start receiving money once you reach the Google payment threshold.",
                    type: "text",
                    url: ""
                },
                {
                    title: "User Side",
                    description:
                        "70 built-in blog posts.\nRandom quotations.\nTotal users display.\nCustom advertisement to generate revenue.\nShare posts on Twitter and Facebook.\nLimit access to some features for registered users only.\nRegistration with Email Verification.\nSecure Login.\nComment on Post.\nReply to the comment.\nRelated Posts.\nSubscribe to the newsletter.\nSocial Links.\nA section to sell items directly.\nAmazon affiliate links.\nRealtime Chat with admin (Firebase).\nManage Profile.\nChange Password.\nCustom Advertisement.",
                    type: "text",
                    url: ""
                },
                {
                    title: "Admin Panel",
                    description:
                        "Dashboard Statistics.\nAdd/Edit blog posts.\nAdd/Edit items that sell directly.\nManage Inbox.\nManage Comments.\nRealtime Chat with users (Firebase).",
                    type: "text",
                    url: ""
                }
            ]
        }, {
            name: "File Transfer Web App in Node.js and MongoDB",
            slug: "file-transfer-nodejs-mongodb",
            price: 99,
            oldPrice: 0,
            featuredImage: "file-transfer-nodejs-mongodb/banner.png",
            images: [],
            categories: ["nodejs", "mongodb"],
            description: "",
            sections: [
                {
                    title: "Demo",
                    description:
                        "A web app that allows you to transfer files to your colleagues, friends, clients, etc.",
                    type: "text_with_video",
                    url: "https://www.youtube.com/embed/ptUBkjVG7dA"
                },
                {
                    title: "Upload files & Create folders",
                    description:
                        "You can upload any type of file e.g. image, e-book, executable, iso etc. Uploaded files can be deleted at any time by the uploader.\n\nTo organize your files, you can create folders and sub-folders with unlimited nesting levels. For example, you can create a folder like “College data” and organize assignments, thesis, and projects inside it.",
                    type: "text_with_video",
                    url: "https://www.youtube.com/embed/cO6faZ7vJfE"
                },
                {
                    title: "Share privately",
                    description:
                        "You can share files via email with users who already have an account. Shared files remain strictly private and cannot be accessed by anyone else, even via server directories.",
                    type: "text_with_video",
                    url: "https://www.youtube.com/embed/epvkU-JXjW8"
                },
                {
                    title: "Share publicly",
                    description:
                        "Files can be shared via a public link that works without login. The link remains active until the owner deletes it. You can also search uploaded or shared files by name.",
                    type: "text_with_video",
                    url: "https://www.youtube.com/embed/94S0Or98LH8"
                },
                {
                    title: "Rename files & folders",
                    description:
                        "Files are automatically named on upload, but you can rename them anytime.",
                    type: "text_with_video",
                    url: "https://www.youtube.com/embed/NFq7HztBa4A"
                },
                {
                    title: "Move files & folders",
                    description:
                        "You can move files and folders while preserving sub-folder structure. Moving a file invalidates previously shared public links.",
                    type: "text_with_video",
                    url: "https://www.youtube.com/embed/l9tqsQDwYbo"
                },
                {
                    title: "Business Model",
                    description:
                        "Monetize by offering limited free storage and charging users for additional GBs. For example, 1 GB free and $1 per extra GB.",
                    type: "text_with_video",
                    url: "https://www.youtube.com/embed/9rQmU9Vd-JE"
                },
                {
                    title: "Admin panel & Team collaboration",
                    description:
                        "Admins can view all users and files. Teams can collaborate in real time, with instant file updates across members using Firebase.",
                    type: "text_with_video",
                    url: "https://www.youtube.com/embed/UgJO78DGSxU"
                },
                {
                    title: "Trash Can",
                    description:
                        "Deleted files go to a recycle bin where they can be restored or permanently deleted. Restoring requires sufficient storage space.",
                    type: "text_with_video",
                    url: "https://www.youtube.com/embed/BOGofW6JWf8"
                },
                {
                    title: "Backup",
                    description:
                        "Users can create a full backup of all their files with a single click.",
                    type: "text_with_video",
                    url: "https://www.youtube.com/embed/8v3PpteZOOc"
                },
                {
                    title: "Blogs",
                    description:
                        "Admins can publish blog posts from the admin panel, and they will automatically appear on the user side.",
                    type: "text_with_video",
                    url: "https://www.youtube.com/embed/Ck715XO14xo"
                },
                {
                    title: "Save space",
                    description:
                        "Images can be compressed to reduce size significantly without losing quality (e.g., 3.2 MB → 890 KB).",
                    type: "text_with_video",
                    url: "https://www.youtube.com/embed/tvFxM-vbvds"
                },
                {
                    title: "Pay-per-usage",
                    description:
                        "Monetize storage by charging users for additional usage beyond free limits.",
                    type: "text_with_video",
                    url: "https://www.youtube.com/embed/NnWZwwHON4Q"
                },
                {
                    title: "Download counts",
                    description:
                        "Publicly shared files can be downloaded without login, and owners can track download counts.",
                    type: "text",
                    url: ""
                },
                {
                    title: "Security",
                    description:
                        "Files are fully private and only accessible to the owner or shared users. Even direct directory access cannot expose files.",
                    type: "text",
                    url: ""
                }
            ]
        }, {
            name: "Image Sharing Web App in Node.js and MongoDB",
            slug: "image-sharing-nodejs-mongodb",
            price: 99,
            oldPrice: 0,
            featuredImage: "image-sharing-nodejs-mongodb/banner.jpg",
            images: [],
            categories: ["nodejs", "mongodb"],
            description: "",
            sections: [
                {
                    title: "Demo",
                    description:
                        "You can upload pictures with captions, like photos and comments. You can search photos by their captions.",
                    type: "text_with_video",
                    url: "https://www.youtube.com/embed/BkF7F2fbLWg"
                }
            ]
        }, {
            name: "Customer Support Chat Widget - PHP, MySQL, Node.js",
            slug: "customer-support-chat-widget",
            price: 99,
            oldPrice: 0,
            featuredImage: "customer-support-chat-widget/banner.jpg",
            images: [],
            categories: ["nodejs", "php", "mysql"],
            description: "",
            sections: [
                {
                    title: "Demo",
                    description:
                        "Users will be able to chat with the admin and get instant replies. Admin will be able to view the navigation history of the user. For example, how many and which pages the user has visited, what was the last page the user has visited, etc.",
                    type: "text_with_video",
                    url: "https://www.youtube.com/embed/56_k1botx9M"
                }
            ]
        }, {
            name: "Questionnaire - Node.js, MongoDB",
            slug: "questionnaire",
            price: 99,
            oldPrice: 0,
            featuredImage: "questionnaire/banner.jpg",
            images: [],
            categories: ["nodejs", "mongodb"],
            description: "",
            sections: [
                {
                    title: "Demo",
                    description:
                        "A web app that allows users to answer questions based on the best of their knowledge in a limited time. The user who answers the most questions correctly ranks 1st, followed by 2nd and 3rd.",
                    type: "text_with_video",
                    url: "https://www.youtube.com/embed/aQMWTGbNfMc"
                }
            ]
        }, {
            name: "Movie Ticket Booking System - PHP, MySQL, MVC",
            slug: "movie-ticket-booking-system",
            price: 99,
            oldPrice: 0,
            featuredImage: "movie-ticket-booking-system/banner.jpg",
            images: [],
            categories: ["php", "mysql", "mvc"],
            description: "",
            sections: [
                {
                    title: "Demo",
                    description: "",
                    type: "text_with_video",
                    url: "https://www.youtube.com/embed/a7GZLmQcOWg"
                },
                {
                    title: "Seasons",
                    description:
                        "Users will be able to watch seasons on your website. You can add as many seasons and episodes as needed from the admin panel.",
                    type: "text_with_video",
                    url: "https://www.youtube.com/embed/Qp6Oe3GNaJ0"
                },
                {
                    title: "Coupon codes",
                    description:
                        "Admin can add coupon codes for special occasions. Users can use them to get discounts on tickets. Payments can be made via Stripe or PayPal to purchase tickets in advance.",
                    type: "text_with_video",
                    url: "https://www.youtube.com/embed/lZNZmZUZAv4"
                },
                {
                    title: "How to setup",
                    description:
                        "Easily set up the project on shared, VPS, or dedicated hosting in under 30 minutes.",
                    type: "text_with_video",
                    url: "https://www.youtube.com/embed/5Rh8KEnMQxM"
                }
            ]
        }, {
            name: "Social Networking Site - Node.js, MongoDB",
            slug: "social-networking-site",
            price: 99,
            oldPrice: 0,
            featuredImage: "social-networking-site/banner.jpg",
            images: [],
            categories: ["nodejs", "mongodb"],
            description: "",
            sections: [
                {
                    title: "Demo",
                    description:
                        "All the functionality you need to launch a social network for your local community.",
                    type: "text_with_video",
                    url: "https://www.youtube.com/embed/Co5a3QbSonU"
                },
                {
                    title: "Authentication",
                    description: "Secure login with encrypted passwords.",
                    type: "text_with_video",
                    url: "https://www.youtube.com/embed/kwPWwczwi6c"
                },
                {
                    title: "Newsfeed",
                    description:
                        "Users can create posts, share updates, and engage with content from others in a dynamic newsfeed.",
                    type: "text_with_video",
                    url: "https://www.youtube.com/embed/fXOWfZ2XSeA"
                },
                {
                    title: "Post interactions",
                    description:
                        "Users can like, comment, reply to comments, and share posts on their timeline.",
                    type: "text_with_video",
                    url: "https://www.youtube.com/embed/YeXOY4vNfEQ"
                },
                {
                    title: "Communicate",
                    description:
                        "Users can send friend requests, build connections, and chat in real time with secure messaging.",
                    type: "text_with_video",
                    url: "https://www.youtube.com/embed/_gusRwy9qmA"
                },
                {
                    title: "Business Pages",
                    description:
                        "Users can create business pages and promote products or services through posts.",
                    type: "text_with_video",
                    url: "https://www.youtube.com/embed/FUgjd0t99Is"
                },
                {
                    title: "Community",
                    description: "Bring like-minded people together in one platform.",
                    type: "text_with_video",
                    url: "https://www.youtube.com/embed/eOaUXBpYpao"
                },
                {
                    title: "Profile visitors",
                    description:
                        "View a list of users who have visited your profile.",
                    type: "text_with_video",
                    url: "https://www.youtube.com/embed/nS7K9xaYBpE"
                },
                {
                    title: "Platform safety & security",
                    description:
                        "Features include end-to-end encryption, user banning, content moderation, adult image filtering, and post moderation tools.",
                    type: "text_with_video",
                    url: "https://www.youtube.com/embed/YHa4rlhjwrA"
                },
                {
                    title: "Temporary updates",
                    description:
                        "Users can post stories that last 24 hours and are automatically deleted after expiry.",
                    type: "text_with_video",
                    url: "https://www.youtube.com/embed/hoLRcjom0fM"
                },
                {
                    title: "Audio notes & events",
                    description:
                        "Support for audio posts, event creation, and embedding YouTube links in posts.",
                    type: "text_with_video",
                    url: "https://www.youtube.com/embed/DQHahy-ZX0A"
                },
                {
                    title: "Advanced features",
                    description:
                        "Includes post boosting with ads, emoji comments, nearby people search, and group chat functionality.",
                    type: "text_with_video",
                    url: "https://www.youtube.com/embed/RMGfYwJQwDU"
                }
            ]
        }, {
            name: "Video Streaming Web App - Node.js, MongoDB",
            slug: "video-streaming",
            price: 99,
            oldPrice: 0,
            featuredImage: "video-streaming/banner.jpg",
            images: [],
            categories: ["nodejs", "mongodb"],
            description: "",
            sections: [
                {
                    title: "Register",
                    description:
                        "Emails are verified during registration to prevent fake accounts.",
                    type: "text_with_image",
                    url: "/img/products/video-streaming/register.png"
                },
                {
                    title: "Login",
                    description: "Login by providing your email and password.",
                    type: "text_with_image",
                    url: "/img/products/video-streaming/login.png"
                },
                {
                    title: "Logout",
                    description:
                        "Prevent accidental logout by asking for confirmation before signing out.",
                    type: "text_with_image",
                    url: "/img/products/video-streaming/logout.png"
                },
                {
                    title: "Home",
                    description:
                        "Greet your users with the latest videos uploaded on your platform.",
                    type: "text_with_image",
                    url: "/img/products/video-streaming/home.png"
                },
                {
                    title: "Upload video",
                    description: "Become a content creator by uploading videos.",
                    type: "text_with_image",
                    url: "/img/products/video-streaming/edit-video.png"
                },
                {
                    title: "Video detail page",
                    description:
                        "Watch videos in full screen with a smooth viewing experience.",
                    type: "text_with_image",
                    url: "/img/products/video-streaming/video-detail.png"
                },
                {
                    title: "Manage your videos",
                    description:
                        "Edit, delete, or deactivate your videos without permanently removing them.",
                    type: "text_with_image",
                    url: "/img/products/video-streaming/my-videos.png"
                },
                {
                    title: "Manage your channel",
                    description:
                        "Customize your channel with name, profile picture, cover photo, and social links.",
                    type: "text_with_image",
                    url: "/img/products/video-streaming/my-channel.png"
                },
                {
                    title: "Notifications",
                    description:
                        "Get notified for every activity happening on your channel.",
                    type: "text_with_image",
                    url: "/img/products/video-streaming/notifications.png"
                },
                {
                    title: "Playlists",
                    description:
                        "Organize videos into playlists for better content grouping.",
                    type: "text_with_image",
                    url: "/img/products/video-streaming/playlists.png"
                },
                {
                    title: "My subscriptions",
                    description:
                        "View and manage all channels you have subscribed to.",
                    type: "text_with_image",
                    url: "/img/products/video-streaming/subscribed-channels.png"
                },
                {
                    title: "Watch history",
                    description:
                        "Rewatch previously viewed videos or clear your history anytime.",
                    type: "text_with_image",
                    url: "/img/products/video-streaming/history.png"
                },
                {
                    title: "Search",
                    description:
                        "Search for videos quickly and easily based on your interests.",
                    type: "text_with_image",
                    url: "/img/products/video-streaming/search.png"
                }
            ]
        }, {
            name: "Realtime Blog - Node.js, MongoDB",
            slug: "realtime-blog",
            price: 99,
            oldPrice: 0,
            featuredImage: "realtime-blog/banner.jpg",
            images: [],
            categories: ["nodejs", "mongodb"],
            description: "",
            sections: [
                {
                    title: "Admin Panel",
                    description: "Manage posts, files, and users from the admin panel.",
                    type: "text",
                    url: ""
                },
                {
                    title: "3 themes",
                    description: "Bootstrap, Clean Blog, Materialize CSS.",
                    type: "text",
                    url: ""
                },
                {
                    title: "Realtime comments and replies",
                    description:
                        "Comments and replies appear instantly without refreshing the page, keeping interactions real-time and seamless.",
                    type: "text",
                    url: ""
                },
                {
                    title: "File Manager",
                    description:
                        "Upload files once and reuse them across multiple blog posts.",
                    type: "text",
                    url: ""
                },
                {
                    title: "Views counter",
                    description:
                        "Track which posts get the most views to optimize future content strategy.",
                    type: "text",
                    url: ""
                }
            ]
        });
    </script>

@endsection