Feature: Setup eZ Platform Enterprise dogs tutorial

    Scenario: Get a starter website
#    Given I create a "Dog Breed" Content Type with "dog_breed" identifier:
#    | Field Type | Name              | Identifier        | Required | Searchable | Translatable |
#    | Text line	 | Name              | name	            | yes      | yes	    | yes          |
#    | Text line	| Short Description	| short_description	| yes      | yes	    | yes          |
#    | Image	    | Photo	            | photo	            | yes      | no	        | no           |
#    | RichText	| Full Description	| description       | yes      | yes	    | yes          |
#    And I create a "Tip" Content Type with "tip" identifier:
#    | Field Type | Name	 | Identifier | Required | Searchable | Translatable |
#    | Text line	 | Title | title	  | yes	     | yes	      | yes          |
#    | Text block | Body	 | body	      | no	     | no	      | yes          |
#    And I remove "image" field from Article Content Type
#    And I add field to Article Content Type
#    | Field Type | Name  | Identifier |	Required | Searchable |	Translatable |
#    | Image      | Image | image      | no	     | no         |	yes          |
#    And test
    And I create "folder" Content items in "Home"
        | contentName       |
        | All Articles      |
        | Dog Breed Catalog |
        | ALl Tips          |
    And I create "article" Content items in "Home/All Articles"
        | contentName                               | imageName    |
        | Dog favorites                             | article1.jpg |
        | Adopt or buy?                             | article2.jpg |
        | Dogs and other pets                       | article3.jpg |
        | Taking care of your dog during a heatwave | article4.jpg |
        | Dog owner's first steps                   | article5.jpg |
        | Traveling with your dog                   | article6.jpg |
#        And I create "dog_breed" Content items in "Home/Dog Breed Catalog"
#        | contentName          | image |
#        | Alsatian             | path1 |
#        | King Charles Spaniel | path2 |
#        | St Bernard           | path3 |
    And I create "tip" Content items in "Home/All Tips"
        | contentName |
        | Tip1        |
        | Tip2        |
        | Tip3        |

    Scenario: Prepare the Landing Page

    Scenario: Use existing blocks

    Scenario: Create a custom block

