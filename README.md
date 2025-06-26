# 📦 PHP MySQL App – Local Development Setup

This is a simple containerized PHP application that connects to a MySQL database and displays the contents of a `test` table. It's designed for quick local testing using Docker Compose.

## ✅ Requirements

- [Docker](https://www.docker.com/)
- [Docker Compose](https://docs.docker.com/compose/)

### 🛠 Step 2: Build and Run the App

```bash
docker compose up --build
```

This will:

- Build the PHP image using Dockerfile  
- Spin up a local MySQL database with the `testdb` schema  
- Auto-run `init.sql` to create the `test` table and insert default data  
- Start the Apache PHP server at http://localhost:8080

---

### 🌐 Step 3: Access the App

Visit:

```text
http://localhost:8080
```

You should see output from the `test` table, like:

```
ID	Name
1	optimy
2	Social impact
3	Sustainability
4	Philanthropy
```
---

### 🧼 Reset the Database (Optional)

If you're not seeing the table, it’s likely the database volume was already initialized. To reset:

```bash
docker compose down -v
docker compose up --build
```

This removes the volume so the `init.sql` is executed again.