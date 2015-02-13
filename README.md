# placement
Simple placement portal website created for software architecture course.
Files are organized as:
* common - comprizes the common DTOs used throughout the project.
  * AdminDTO.php
  * JafDTO.php
  * PlacedStudentDTO.php
  * StudentSearchDTO.php
  * CompanyDTO.php
  * LoginDTO.php
  * StudentDTO.php
* tier1 - comprizes files dealing with code mainly used for display.
  * admin.php
  * css - the css stylesheet used in the project
    * login.css
    * main.css
  * index.php
  * student.php
  * verifySession.php
  * company.php
  * dpc.php
  * logout.php
  * test.php
* tier2 - comprizes code that forms the 'business logic' of the project. Also includes the presentation layer formatter classes. This was a judgement call, could have included these in the tier1.
  * AdminBL.php
  * CompanyDataFormatHelper.php
  * LoginBL.php
  * AdminDataFormatHelper.php
  * DPCBL.php
  * PlacedDataFormatHelper.php
  * CompanyBL.php
  * JafDataFormatHelper.php
  * StudentBL.php
* tier3 - deals with code that communicates to and from the data base.
  * AdminDAO.php
  * CompanyDAO.php
  * DPCDAO.php
  * AuthenticateHelper.php
  * DBConnection.php
  * StudentDAO.php
* placement.sql - sets up the DB and adds some sample data.
  
The code is almost entirely object oriented written using php classes except for the code in tier1 whihc is scripted as it majorly include html code.
The css is also custom and inspired from Android colorscheme.

## There are following agents in the scenario.
  * DPC - department placement co-ordinator. Adds companies to the DB.
  * admin - repsonsible for setting a student as DPC.
  * student - one who takes part in the placement. Applies to companies and signs job application forms.
  * company - floats job application forms and annouce results.
