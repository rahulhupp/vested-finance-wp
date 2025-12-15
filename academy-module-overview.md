# Academy System — Documentation

This document describes the content structure, user authentication flow, access control, and admin workflow for the Academy system.

---

## 1. Content Structure

### **Module (Course)**
- **Post type:** `academy_module`
- **URL:** `/academy/{module-slug}/`

### **Chapter (Lesson)**
- **Post type:** `module`
- **Linked To:** A module via ACF field `academy_module`
- **URL:** `/academy/{module-slug}/{chapter-slug}/`

### **Topic (Sub-Lesson)**
- **Post type:** `chapter_topic`
- **Linked To:** A chapter (parent or ACF mapping)
- **URL:** `/academy/{module-slug}/{chapter-slug}/{topic-slug}/`

### **Quiz**
- **Post type:** `quiz`
- **Linked To:** A chapter using ACF field `quiz_links`
- **Questions:** Stored in quiz post via ACF field `quiz_questions`
- **Display:** Shown inline on chapter page using:
  ```
  /academy/{module-slug}/{chapter-slug}/?quiz=1
  ```

---

## 2. URLs & Navigation

- Topic URLs use clean, slug-based routing.
- When a chapter is accessed **without a topic selected**, the system automatically **redirects to the first topic**.
- Chapter + Quiz share the same page; quiz appears based on `?quiz=1`.

---

## 3. User Login

- Login URL: `/academy/login`
- Requires:
  - Username **or** email
  - Password
- Users with **unverified email** cannot log in.
- After successful login, users are redirected to the **Academy homepage**.

---

## 4. User Signup & Verification

Signup URL: `/academy/signup`

### **Signup Requirements**
- Username  
- Email address  
- Password + Confirm password  

### **After Registration**
- User is assigned role: **Academy User**
- A **verification email** is sent automatically
- Verification link expires in **24 hours**

### **Verification Flow**
1. User clicks the verification link containing a unique token  
2. Account is activated  
3. User is redirected to the **login page**

If a token expires, the user can request a **new verification email**.

---

## 5. Access Control

| Feature | Public | Login Required |
|--------|--------|----------------|
| Modules | ✔️ | — |
| Chapters | ✔️ | — |
| Topics | ✔️ | — |
| Quizzes | — | ✔️ |
| Progress Tracking | — | ✔️ |

Additional behavior:
- Quiz links show a lock icon with shown content when the user is not logged in.
- Topic/chapter progress is stored only for logged-in users.

---

## 6. Admin Workflow

### **1) Create a Module (Course)**
- Add new post in **Academy Module**
- Fill title, description, difficulty, image, etc.

### **2) Add Chapters (Lessons)**
- Create a **Module** post
- Link to parent module via ACF `academy_module`
- Sort using **menu order**

### **3) Add Topics**
- Create a **Chapter Topic** post
- Set parent chapter
- Add content, duration
- Order using **menu order**

### **4) Attach Topics to Chapters**
- **Preferred method:** ACF `chapter_topic_links` on the chapter  
  (Gives manual ordering control)
- **Fallback:** WordPress parent + menu order

### **5) Add Quiz**
- Create a **Quiz** post
- Add questions via ACF field `quiz_questions` on the quiz post
- Set passing score, time limit, and other quiz settings
- Link quiz to chapter via ACF `quiz_links` field on the chapter
- Quiz appears inline on chapter page when `?quiz=1` is present

---

## 7. Front-End Behavior

- Sidebar shows hierarchical learning structure:
  ```
  Module
   ├── Chapter 1
   │     ├── Topic 1
   │     ├── Topic 2
   │     └── Quiz
   ├── Chapter 2
   │     ├── ...
  ```
- Current chapter is **expanded**
- Current topic is **highlighted**
- Quiz appears below its parent chapter