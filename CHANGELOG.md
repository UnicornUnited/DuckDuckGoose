#Members
- T Guan
- T Stickney
- T Cabrera
- J Liang

#Style Conventions
- 4 space indentation


# Changelog
All notable changes to this project will be documented in this file.

# [latest stable version 2.0.0]

## [3.0.0] - 2017-11-26
## Changed
 - FlightModel controller to retrieve available flights by specified departure
 - 

## Added
 - Views to display booking options: booking_row.php, booking_header.php, booking_option.php

## [3.0.0] - 2017-11-23
## Changed
 - Add unit test against business logic on fleet.
 - Update unit test on flight due to the change of data structure.
 - Add checking for sufficient budget on purchase.

## [3.0.0] - 2017-11-22
## Changed
 - Display more information on fleet page and plane page.
 - Link fleet and plane pages.
 - Enable adding new plane to fleet.
 - Fixed a few view and controller bugs related to fleet feature.
 - Updated documentation for a few newly added functions.

## [3.0.0] - 2017-11-21
## Changed
 - Views beautification.
 - Update Fleet and Flight due to the change of model_id in data source.

## [2.0.0] - 2017-11-12
## Added 
###Controllers
 - Booking controller to handle the flight booking feature
 - Fixed controller flights as a piece of code was generating errors when trying to update or add a flight in admin mode
###Views
 - flightbooking.php to display the inputs for departure and destination airports
 - flightbooking_display.php to display the flights that match the input
 - fleetedit view to display fleet edit page for admin user
 - planeedit view to display plane edit page for admin user
###Tests
 - Added logging (code coverage report)

## Changed 
###Models 
 - Put a method in the FlightModel to retrieve flights that match a specifc
   departure and destination airport
 - Add functions to fleetModel and flightModel to handle saving data to data file.
 - Added additional validaiton (regex) rules via the models. Changes done to remove unused code as they were implemented with entities.
###Controllers
 - Change Controller Flights to ensure the Admin role can see editable fields and update them correctly in the CSV file 
 - Add functions Fleet Controller to allow admin user to modify fleet.
 - Enable editing and adding flights on the flight page with admin role.
###Views
 - Change view adminflights to ensure the Admin role can see editable fields and update them correctly in the CSV file
 - Modified fleet and plane views to work with new properties.
  - Fixed layout issues in flights user views
###Tests
 - Add a few unit test cases for flight and flightModel

## [2.0.0] - 2017-11-11
## Changed
 - Changes were made to the flights view to maintaining consistency in both mobile and desktop mode

## Added
### Models
 - Entity Model for base class of entities.
 - Flight.php use as base class for all flight instances.
 - Plane.php use as base class for all plane instances.
### Controllers
 - Added functionality to Flight controller to allow Admin to make changes to flight data
 
### Views
 - Created adminflights page which renders additional functionalities to the admin

## [2.0.0] - 2017-11-10
## Changed
 - Rearrange fleet and plane view files.

## [2.0.0] - 2017-11-09
## Changed
 - Add user role selection to the menu bar.
 - Display user role on page title and an indicator on the role drop-down.
 - Modify page views for data mapping from CSV.
 - Modify flight and fleet models to extend from an appropriate CSV model.
## Added
### Controllers
 - User role controller.
 - Removed PHP closing tag to avoid session php error. No need to close tags
### Models
 - Wacky model to retrieve shared data from wacky server.
 - Add CSV model that supports CSV data type.
### Views
 - Fixed layouts for consistent view on each page.
 - Fixed header background picture to be responsive and to resize correctly.

# [version 1.0.0 released] - 2017-10-08

## [1.0.0] - 2017-10-08
## Changed
- Updated config/config with links for the menubar.(Teresa)
- Updated style.css to modify appearance of Flights table.(Teresa)
- Cleaned up spelling mistakes. (Takito)
### Controllers
- Updated Fleet controller to work with menubar rendering.(Teresa)
- Updated MY_Controller to parse menu_choices.(Teresa)
- Welcome controller to display the homepage. (Taryn)
### Models
- Updated FlightModel.php to include more attributes for each flight.(Teresa)
### Views
- Updated plane_list view use anchors.(Teresa)
- Updated plane_item view to use appropriate placeholders.(Teresa)
- Updated template view with placeholder for menubar.(Teresa)

## Added
- Comments (Taryn)
### Controllers
- Flights controller to allow listing of the flight schedule and details.(Teresa)
### Views
- _menubar view for menubar template.
- flights view to format the flights details on webpage.(Teresa)
- View to display the homepage. (Taryn)
- Added About page (Takito)

## [1.0.0] - 2017-10-07
## Added
### Models
 - Fleet feature which allows listing planes in the fleet and view plane detail.

## [1.0.0] - 2017-10-06
## Added
### Controllers
 - Info Controller to provide RESTish services for Fleet and Flights models.
 
## Changed
### Models
- Renamed the models to avoid name conflicts with controllers. 
### Views
- Made the template file into a custom template.

## [1.0.0] - 2017-10-05
## Added
- The CI starter package.
- A webhook to the server.
### Models
- Fleet and Flights Models ~Takito
