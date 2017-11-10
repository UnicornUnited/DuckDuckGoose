#Members
- T Guan
- T Stickney
- T Cabrera
- J Liang

#Style Conventions
- 4 space indentation


# Changelog
All notable changes to this project will be documented in this file.

# [latest stable version 1.0.0]

## [2.0.0] - 2017-11-09
## Changed
 - Add user role selection to the menu bar.
 - Display user role on page title and an indicator on the role drop-down.
## Added
### Controllers
 - User role controller.
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