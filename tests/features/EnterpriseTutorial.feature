Feature: Setup eZ Platform Enterprise dogs tutorial

    Scenario: Get a starter website
    Given I create a "Dog Breed" Content Type with "dog_breed" identifier:
    | FieldType | Name              | Identifier        | Required | Searchable | Translatable |
    | Text line	| Name              | name	            | yes      | yes	    | yes          |
    | Text line	| Short Description	| short_description	| yes      | yes	    | yes          |
    | Image	    | Photo	            | photo	            | yes      | no	        | no           |
    | RichText	| Full Description	| description       | yes      | yes	    | yes          |
    And I create a "Tip" Content Type with "tip" identifier:
    | Field Type | Name	 | Identifier | Required | Searchable | Translatable |
    | Text line	 | Title | title	  | yes	     | yes	      | yes          |
    | Text block | Body	 | body	      | no	     | no	      | yes          |
#    And I remove "ezobjectrelation" field from Article Content Type
#    And I add "Image" field to Article Content Type
#    | Field Type | Name  | Identifier |	Required | Searchable |	Translatable |
#    | Image      | Image | image      | no	     | no         |	yes          |
#    And I copy needed templates, configuration and style files
#    And I create 3 "Folder" Content items in "Home"
#        | contentName       |
#        | All Articles      |
#        | Dog Breed Catalog |
#        | ALl Tips          |
#    And I create 4 "Article" Content items in "Home/Dog Breed Catalog"
#        | contentName | image |
#        | Article1    | path1 |
#        | Article2    | path2 |
#        | Article3    | path3 |
#        | Article4    | path4 |
#    And I create 3 "Tip" Content items in "Home/All Tips"
#        | contentName | image |
#        | Tip1        | path1 |
#        | Tip2        | path2 |
#        | Tip3        | path3 |
#        | Tip4        | path4 |

    Scenario: Prepare the Landing Page

    Scenario: Use existing blocks

    Scenario: Create a custom block

