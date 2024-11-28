# WishJar: A Drupal-Based Wish-Sharing Platform
**WishJar** is a platform where users can document, share, and explore wishes to inspire and connect with others. 
Whether it’s climbing a mountain, starting a business, or learning a new skill, this website provides a space to turn aspirations into inspirations.

This app was designed using Drupal as part of my journey to explore rupal development. I think Drupal offers more customization compared to WordPress.
The project is containerized using DDEV and Docker, providing a more efficient, portable development environment. I leveraged key Drupal features, including:
- Blocks and Views: To create flexible content displays.
- CSS and Twig: For custom styling and theming.I also integrated tailwindcss with twig.
- Flags: To implement functionality like "Follow User." 
- User Relationships: To manage interactions between users.

### **Basic Site Settings**

| **Setting**      | **Details**                             |
|-------------------|-----------------------------------------|
| **Logo**          |![Weixin Screenshot_20241121233007](https://github.com/user-attachments/assets/67767544-baaa-4668-92df-bd62918f6c20) |
| **Slogan**        | *"Every Wish Deserves a Place"*         |
| **Theme Colors**  | Soft blues and greens to evoke calm and inspiration. |

---

## **User Roles and Permissions**
![wishtag](https://github.com/user-attachments/assets/3e54840e-8318-49bc-84df-03c9858a9ed1)


| **Role**             | **Capabilities**                                                                                  |
|-----------------------|--------------------------------------------------------------------------------------------------|
| **Unregistered Visitor** | - View wishes posted by registered users. <br> - Cannot create or modify wishes.               |
| **Registered User**   | - Write new wishes (title, tags, body text, images). <br> - Edit or delete their own wishes. <br> - Like, save, comment, or share wishes. <br> - Follow authors to display their posts on the Following Wish List (`/inspiration-jar`). |
| **Admin User**        | - Delete wishes. <br> - Censor wishes or manage new users. <br> - Cannot write or edit wishes.   |

---

## **Pages and Features**



### **Page Structure**
#### Frontpage (Home Page)
**Wish Tag Board**: Displays main taxonomy of wishes. <br> - **Trending Wishes**: Wishes with high votes and comments. <br> - **New Wishes**: Newly published wishes. 

| **Page**                      | **Details**                                                                                           |
|--------------------------------|-------------------------------------------------------------------------------------------------------|
| **full page**      |![full](https://github.com/user-attachments/assets/7a571cfe-bfd3-422a-acdc-fc2ce6b0b0c5)|
| **Wish Tag Board**      |![wishtag](https://github.com/user-attachments/assets/b8c49a16-4401-436f-b752-07fdba9a9517) |
| **Trending Wishes** |![front-bottom](https://github.com/user-attachments/assets/931b29a0-aaad-4c6b-9f56-12708233018c) |
| **New Wishes** | ![newwished](https://github.com/user-attachments/assets/76495f7f-79aa-466a-8e3b-56f515498029)|

---

#### My Account Page (`/user/*`)
- Public profile page with a personal profile card (user picture, follow button, self-intro). <br> - Editable only by the user. 

| **Page**                      | **Details**                                                                                           |
|--------------------------------|-------------------------------------------------------------------------------------------------------|
| **full page**      | ![user](https://github.com/user-attachments/assets/bc460179-3a75-4cdb-a2ad-39035a81c394)|
| **Public profile** | ![sectionprofile](https://github.com/user-attachments/assets/8c887588-56bb-4671-91e0-2313a3bf1b88) |

 ---
#### Following Wish List (`/inspiration-jar`)
- Displays wishes from authors the logged-in user follows. <br> - For anonymous visitors, shows trending wishes only.

#### Wish Detail Page** (In Progress)
- Displays individual wish details, including interactions like likes, comments, and shares.

#### Tag Display Page(Planned) 
- Displays posts related to a specific tag. 

####  Additional Pages 
 Define and develop remaining pages as needed.

---

## **Instructions: Set Up the Project with DDEV on Windows**

### **Prerequisites**
1. Install [DDEV](https://ddev.readthedocs.io/en/stable/).
2. Install Docker Desktop.

---

### **Steps to Clone and Set Up the Project**

1. **Clone the Repository**:
   ```bash
   git clone <repository-url>
   cd <project-folder>
   ```

2. **Set Up DDEV**:
   - Run the following command in the project folder:
     ```bash
     ddev config --project-type=drupal --docroot=web --php-version=8.1 
     ```
   - Start the DDEV environment:
     ```bash
     ddev start
     ```

3. **Install Drupal**:
   - Access the DDEV environment:
     ```bash
     ddev ssh
     ```
   - Install Drupal using Drush:
     ```bash
     drush site:install --account-name=admin --account-pass=admin
     ```

4. **Access the Site**:
   - Open your browser and navigate to:
     ```
     https://<project-name>.ddev.site
     ```
 
