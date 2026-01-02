# 💡 Project Overview
AnakKost, a property management solution designed to help boarding house managers efficiently oversee their tenants and properties. 

# 💻 Demo
<!-- <table>
  <tr>
    <td width="50%">
      <img width="100%" alt="Home Page" src="https://github.com/user-attachments/assets/78e7b311-8abd-4cab-9411-ac0e70a393db" />
    </td>
    <td width="50%">
      <img width="100%" alt="Roasting Page" src="https://github.com/user-attachments/assets/f396da10-ef1b-4379-9dfa-ddfd581a878f" />
    </td>
  </tr>
</table> -->

# ✨ Features
- 🔐 Role-Based Authentication:
   - Admin (Kost Owner): Full access to manage rooms, tenants, and payments.
   - User (Tenant): (Optional) Can view their own payment history or profile.

- 🏠 Room Management:
   - CRUD Operations: Add new rooms, edit prices/facilities, and delete listings.
   - Status Tracking: Automatically track if a room is "Available," "Occupied," or "Under Maintenance."

- 👥 Tenant Management:
   - Digital Records: Store tenant identity (KTP), phone numbers, and emergency contacts.
   - Room Assignment: Assign specific tenants to specific rooms.

- 💰 Payment & Billing:
   - Transaction Recording: Input monthly rent payments.
   - Payment History: View past payments to see who has paid and who is in arrears (nunggak).

- 📊 Dashboard Overview:
   - Visual summary of Total Income, Occupied Rooms, and Empty Rooms at a glance.

# 🛠️ Tech Stack & Architecture
- **Architecture** – MVC (Model-View-Controller)
- **Framework** – Laravel (PHP)
- **Frontend** - Blade Templates, Bootstrap (or Tailwind CSS), CSS3
- **Backend** – PHP
- **Database** - MySQL
- **Tools** - Eloquent ORM, Artisan Console

## 🌐 Deployment
This application is deployed using Railway.

Live Demo: https://anakkost.up.railway.app/
