# AJAX Archive Enhancements

This is code I wrote for a project where the client wanted an archive of posts that had custom AJAX filtering by certain categories and also loaded more posts on scroll. I couldn't find any plugins that did exactly what I needed, so I did it myself.

## Getting Started

If you want to use this code, you'll need to make sure you have a solid enough understanding of WordPress to point to the correct files and folders. If you've got any questions, I'd be glad to help!

### Credit Where Credit is Due

I used the following guides to get myself started. You may find it helpful to read through them yourself as well.


* [Filter/Sort post by categories using Ajax in WordPress](http://blog.onclickinnovations.com/filter-sort-post-by-categories-using-ajax-in-wordpress/) by [Rohit Sharma](http://blog.onclickinnovations.com/author/rohit/)
* [AJAX with loop filtering categories](https://wordpress.stackexchange.com/questions/124504/ajax-with-loop-filtering-categories) from StackExchange
* [Filter WordPress posts by custom taxonomy term with AJAX and pagination](https://www.bobz.co/filter-wordpress-posts-by-custom-taxonomy-term-with-ajax-and-pagination/) by [Vlado Bosnjak](https://www.bobz.co/author/adminfs/)

## Notes

* You can also check out my own StackExchange question where I had the final breakthrough on my work: [check it out here](https://wordpress.stackexchange.com/questions/287220/ajax-load-more-posts-not-using-correct-category-and-repeating-the-same-few-posts).
* This was all done in a Genesis child theme, so you may have to modify the code in the template file accordingly.
* If you'd like to see this feature in action, go to [Dare2Share's Website](https://www.dare2share.org/resources/youth-ministry-articles/).
* I recommend building a custom plugin in which to place ajax-archive.php and ajax-filter-posts.js. Put template-articles.php (or whatever you rename it) in your child theme folder.
