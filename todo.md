1. **User Authentication & Authorization Model**:
   - Manages users, roles, and permissions.
   - Supports login, registration, and role-based access control.

2. **Invoice Model**:
   - Core model for storing invoice details like invoice number, date, customer, and status.
   - Tracks line items (products/services), quantities, and prices.

3. **Customer Model**:
   - Stores customer details such as name, contact info, address, and payment preferences.
   - Links to the Invoice model for associating customers with their invoices.

4. **Product/Service Model  (Item)**:
   - Catalog for storing items (products or services) offered.
   - Contains fields like name, description, SKU, price, and tax information.

5. **Tax & Discount Models**:
   - Separate models to manage taxes (e.g., VAT, GST) and discounts (percentage or flat rate).
   - Flexible enough to apply different tax rates or discounts per item or invoice.

6. **Payment Model**:
   - Tracks payments made against invoices.
   - Fields for payment method, date, amount, and reference to the invoice.

7. **Template Model**:
   - Stores templates for invoice formatting (PDF, HTML, etc.).
   - Allows users to customize the appearance of invoices.

8. **Currency & Exchange Rate Model**:
   - Supports multi-currency invoices by storing currency types and exchange rates.

9. **Notification/Reminder Model**:
   - Sends automatic email or SMS reminders for overdue invoices.
   - Tracks when reminders are sent.

10. **Audit & History Model**:
    - Logs changes to invoices, payments, and customer data.
    - Helps maintain a clear audit trail for compliance and tracking purposes.

11. **Analytics & Reporting Model**:
    - Provides insights into sales, outstanding invoices, tax collected, etc.
    - Generates summary reports for users.
    - number of invoices generated and how many left for the month



***TODO ***
1. add default currency ( maybe to the business table)
2. how much revenue comes from selling products vs. providing services.