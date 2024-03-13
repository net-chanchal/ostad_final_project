# Final Project | JobPulse

### Project Setup
Open the terminal and run the following commands:
```text
git clone https://github.com/net-chanchal/ostad_final_project
cd ostad_final_project

composer update

php artisan storage:link
```

### Environment Setup

1. Create a Database `ostad_final_project`
2. You can manually import the database `database/ostad_final_project.sql`
3. Modify the `.env` file if necessary.
4. Add SMTP information for email sending


### Run the Development Server
To start the Laravel development server, execute the following command:
```text
php artisan serve
```

### Test the Route
Visit the following URL in your web browser to test the route:
```text
http://127.0.0.1:8000
```
### Sample Login Information

```text
Admin: http://127.0.0.1:8000/admin/login
Email: admin@gmail.com
Password: 12345

Employer: http://127.0.0.1:8000/login
Email: sophia.martinez@example.com
Password: 123456

Job Seeker: http://127.0.0.1:8000/login
Email: john.smith@example.com
Password: 123456
```


**IMPORTANT INSTRUCTIONS**

Please follow the detailed explanation discussed in the main live class. You have to download the Application Sketch
File from the Drive then open it with any browser. How to use the file has been shown in the main live class.

Apply your knowledge to add CRUD operations where necessary. As it is your final project so we are not giving you any
instructions on database table structures and data modeling. As a developer you should apply your knowledge for this.

We are not providing any HTML Templates for this project so that the project of each and everyone remains different.
For the authentication Login with Google is Optional.

You have to make a video of the project where each and every feature is visible and upload it in the root of your
GitHub Repository for this project.  
_Must Submit GitHub Link._

- You must need to see the Main Project Analysis Class before doing this assignment.
- For your Final Project, you have to make a Job Portal Management System name “JobPulse”.
- There will be 3 types of User : Main Owner of The System, Companies and Candidates.
- For the Main System Owner Company and Job Providing Companies, you have to maintain Roles & Permissions(Optional).
- Main System Owner Company can only login in the site.
- Job providing companies can register and login in the site.
- Candidates can apply to the posted jobs under any company. Before applying candidates must be logged in into the
  system.
- For The Owner of the system, you have to develop these Modules:
    - Frontend: Home Page, About Page, Jobs Page, Contact Page, Login Page.
- The Login Route will be different for the Main Owner.
    - Backend: Dashboard, Companies, Jobs, Employee(Optional), Blogs, Pages, Plugins, Accounts Settings
- For The Job Providing Companies, you have to develop these Modules:
    - Frontend Part: Login, Registration and Forget Password
    - Backend: Dashboard, Jobs, Employee(Optional), Blogs , Plugins, Accounts Settings.
- For Job Providing company, Blogs Feature on backend, need to add just as a plugin. No need to develop as a whole
  functional feature.
- Employee module is declared as optional for Owner of the system and Companies but you have to keep it as a plugin. If
  you do not develop this feature with Roles and Permissions then just keep this as plugin card like other plugins.
- For The Candidates, you have to develop these Modules:
    - Frontend Part: Login, Registration and Forget Password
    - Backend: Dashboard, Jobs, Profiles, Accounts Settings

Application Sketch Template Link:
Make sure you download this file and open it with any browser (Ref: Main Live Class)

https://drive.google.com/file/d/1yftKVqW-YrMIkvhq9BE2nO-Us094P5sL/view?usp=sharing