<div class="container" id="contacts">
    <h1> Keep in touch with us!</h1>
    <p> Let us know any problems and suggestions you have. Fill this form with information about your problem or suggestion, which will then be reviewed by an administrator. We will do our best to give you a quick response.</p>
    <form action="{{ url('/contacts') }}" method="post">
        {{ csrf_field() }}
        <fieldset>
            <div class="form-group">
                <label for="contact_email">From</label>
                <input type="email" class="form-control" name="email" id="contact_email" placeholder="name@example.com" required>
            </div>
            <div class="form-group">
                <label for="contact_subject">Subject</label>
                <input type="text" class="form-control" name="subject" id="contact_subject" placeholder="Describe the problem in few words" required>
            </div>
            <div class="form-group">
                <label for="contact_description">How can we help?</label>
                <textarea class="form-control" name="content" id="contact_description" rows="8" placeholder="Please describe your problem and how we can help..." required></textarea>
            </div>
            <button type="submit" class="submit_action_btn">Send Request</button>
        </fieldset>
    </form>
</div>