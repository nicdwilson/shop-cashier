# Shop cashier

A simple plugin that creates a `Shop cashier` user role, and limits the access of the Shop cashier to products in the category with the slug `offline`.

This allows a Woo mobile user to create an order for WooPayments In Person Payments without having to scroll through an extensive list of products which are not available in the physical shop, but are available on the site for online only purchase.

It speeds things up in order creation and checkout.

The Shop cashier will not be able to view all products on the site while logged into the site, but can view all products on the front end of the site if they are logged out.

for this reason, the Shop cashier role should be regarded as extremely limited, and possibly for use when logging into the site with the Woo mobile app.
