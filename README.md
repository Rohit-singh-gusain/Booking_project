# PHPFlix - Cinema Ticket Booking System
The aim of this project is to create a fully functional online cinema ticket booking system. The purpose of the application is to provide the user with the ability to navigate comfortably in its environment in order to complete as easily as possible the action for which he visited the specific application in the first place. Therefore, it is necessary to design an environment friendly to the user and his needs, in which he can choose the film he wants, learn about it and make the requested reservation. Also, the user, as now registered, will be able to search for information about his past reservations. This entails the creation of the cinema database, where user and film information will be kept securely.
The application, in addition to customers, is also addressed to cinema employees who through the application have complete control over their responsibilities. The application provides the employee with a specialized dashboard with all the information he needs, such as the total number of reservations and details of each of them. The control panel also makes it possible to add or even update a movie to the existing cinema list as well as to manage the available seats for each one of them.

Below are some screenshots of the application's user interface:

![Homepage1](https://user-images.githubusercontent.com/91207835/203422125-ba6ec5a0-ec06-432a-a806-238163e2aad2.png)
![Homepage2](https://user-images.githubusercontent.com/91207835/203422172-844c08e5-b260-4bcd-8058-a0e5e47523a4.png)
![MoviePageExample1](https://user-images.githubusercontent.com/91207835/203422218-cd9e0ad6-56c9-477b-9113-93c44aaa313c.png)
![MoviePageExample2](https://user-images.githubusercontent.com/91207835/203424916-991f3636-f7dd-40b0-9bbd-5548777d145f.png)
![AdminDashboard1](https://user-images.githubusercontent.com/91207835/203422270-137143e0-0b3d-4cc3-8892-e8afd2e4e230.png)
![AdminDashboard2](https://user-images.githubusercontent.com/91207835/203422347-fce9f2e7-0cbe-4c4d-a75c-3c1ef2ac53a3.png)
![CustomerRegistrationForm](https://user-images.githubusercontent.com/91207835/203422416-3aae7cc7-3a8b-4a6b-85ab-ce5cedb355b5.png)

**Good to Know**
- Database connection credentials can be changed in /database/config.php.
- Admin Dashboard URL: /admin/index.php
- Admin Account:    
    username: admin1    
    password: admin123
- User Account:     
    username: user  
    password: ChrisBandis1

**Known Issues**

There is no full support for smaller resolutions by the application as there is a problem in displaying the menu on the movie pages as well as, the size of the frame containing the booking form becomes smaller than the size of the form and consequently the size of the image representing the seats of the cinema changes (see images below). 

![Issue1](https://user-images.githubusercontent.com/91207835/203423924-63191056-9ff7-4f13-a15f-8fbeb589e223.png)
![Issue2](https://user-images.githubusercontent.com/91207835/203423977-9d959e07-89ec-43ac-a81a-94741ecb863b.png)


