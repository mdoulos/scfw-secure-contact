![secure-contact-example-dual](https://github.com/user-attachments/assets/5e8c7f29-9b52-4443-a47a-a5b5b418b417)

How it Works
Users can put the shortcode [scfw-form] in a post or page and the contact form will work right away, even with nothing setup. If the “to” address is missing for example, it will default to the site’s admin address. But there are numerous options to customize the functionality of the form. On the front end, the site visitor fills out the required contact form inputs and then they’re presented with a random word presented in the form of 4 images called a “Real Person Test”. These images will look like “CON + TACT =” or “WORD PART 1 + WORD PART 2 =” and the site visitor is expected to combine the first and second half of the word in the Answer input, such as Contact. This input is case insensitive. All that matters is they put in the right word: contact, CONTACT, CoNTaCt, etc.

If they put in the right word and all of the required fields are filled in, the site visitor will either stay on the page with a submission notice or be redirected to an optional thank you page. The submission will be sent to the “to” email address and the “reply-to” header will be the site visitor’s email address if it was a valid address. If the required fields weren’t filled in, they will be highlighted red and the visitor will be prompted to input the fields. If the required fields are filled in and the real person test is wrong, the visitor will be told to try the field again an optional amount of times (could be set to 1 try or 1000). If the visitor fails to pass the real person test within the attempt limit set up in the admin page, then the suspected bot is either redirected to an optional page or kept on page with a submission notice. At no point is the bot told that it failed the test. It will look like the bot successfully submitted the form, so as not to attract the attention of the bot developer.


Options
Site administrators are able to set up the email headers to control who the submissions are sent to and who gets replied to. In this way, the customer or site visitor can be replied to directly from the submission email if desired.

The random words that appear in the real person test can be configured to follow certain themes that cover a range of industries like transportation, clothing, and travel. Alternatively, they can be gibberish every time, ensuring a compatible match with unsupported industries.

The color of the security image overlay and the color of the submit button can be styled from the admin page. The default styling for the inputs and the rest of the form should work for a majority of sites, but additional styling may be required by the developer for your specific site needs.

Inputs can be turned off or required. Each input can have the order of its appearance changed, and the labels and placeholders may also be changed.

![secure-contact-example-1](https://github.com/user-attachments/assets/05a277f6-2cb6-4a01-9cc3-f98a00d9c111)

Tracking
Basic tracking occurs every time a form is submitted. It keeps track of successful and blocked submissions. When a submission is blocked or the security feature answer is wrong, additional tracking distinguishes between likely human vs likely bot answer failures.
