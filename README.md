# bricks-class-manager

## Current status
### Parsing classes
my original regex was based on my own framework and did not take into consideration multiple other ways of defining class paths.

I have updated the regex which correctly extracts class names with the following test CSS.

The tricky part was extracting teh class names and not the floats.

Regex: /\.([^\d][0-9a-z-A-Z_\-]+[^.,{])/

CSS:
<pre><code>
:root{
  --test-var: 0.9945px;
}
.teS-t_88{
	color: red;
}

.test2 .test3 {
	color: red;
}

.test-_aa.dtestbb{
	color: red;
}

.test4,.test5{
	color: red;
}
@media(max-width:777px){
  .test_99-a{
	color: red;

	}
  .test_99-b .test_99-c{
	color: red;

	}

  .test_99-d.test_99-e{
	color: red;
	}
}
</code></pre>