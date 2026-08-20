// ================= SERVICE =================

function selectService(serviceName) {

    document.getElementById("service").value = serviceName;

    document.getElementById("booking")
        .scrollIntoView({
            behavior: "smooth"
        });
}


// ================= TIME =================

function selectTime(time) {

    document.getElementById("selectedTime").value = time;

    const buttons =
        document.querySelectorAll(".time");

    buttons.forEach(function(button) {

        button.classList.remove("selected");

    });

    buttons.forEach(function(button) {

        if (button.innerText === time) {

            button.classList.add("selected");

        }

    });
}


// ================= BOOKING =================

document
    .getElementById("bookingForm")
    .addEventListener("submit", function(event) {

        event.preventDefault();


        const name =
            document.getElementById(
                "customerName"
            ).value;

        const email =
            document.getElementById(
                "customerEmail"
            ).value;

        const service =
            document.getElementById(
                "service"
            ).value;

        const date =
            document.getElementById(
                "appointmentDate"
            ).value;

        const time =
            document.getElementById(
                "selectedTime"
            ).value;


        // Check time

        if (time === "") {

            alert(
                "Please select an appointment time."
            );

            return;
        }


        // Create booking object

        const booking = {

            name: name,

            email: email,

            service: service,

            date: date,

            time: time

        };


        // Save booking

        localStorage.setItem(
            "salonBooking",
            JSON.stringify(booking)
        );


        alert(
            "Appointment booked successfully!"
        );


        displayBooking();

    });


// ================= DISPLAY BOOKING =================

function displayBooking() {

    const data =
        localStorage.getItem(
            "salonBooking"
        );


    const container =
        document.getElementById(
            "bookingDetails"
        );


    if (!data) {

        container.innerHTML =
            `<p class="no-booking">
                No booking available.
             </p>`;

        return;
    }


    const booking =
        JSON.parse(data);


    container.innerHTML = `

        <div class="booking-card">

            <h3>
                ${booking.service}
            </h3>

            <p>
                <strong>
                    Customer:
                </strong>

                ${booking.name}
            </p>

            <p>
                <strong>
                    Email:
                </strong>

                ${booking.email}
            </p>

            <p>
                <strong>
                    Date:
                </strong>

                ${booking.date}
            </p>

            <p>
                <strong>
                    Time:
                </strong>

                ${booking.time}
            </p>

            <p>
                <strong>
                    Status:
                </strong>

                Confirmed
            </p>


            <button
                class="modify-btn"
                onclick="modifyBooking()">

                Modify Booking

            </button>


            <button
                class="cancel-btn"
                onclick="cancelBooking()">

                Cancel Booking

            </button>

        </div>

    `;
}


// ================= MODIFY =================

function modifyBooking() {

    const data =
        localStorage.getItem(
            "salonBooking"
        );


    if (!data) {

        alert(
            "No booking found."
        );

        return;
    }


    const booking =
        JSON.parse(data);


    document.getElementById(
        "customerName"
    ).value = booking.name;


    document.getElementById(
        "customerEmail"
    ).value = booking.email;


    document.getElementById(
        "service"
    ).value = booking.service;


    document.getElementById(
        "appointmentDate"
    ).value = booking.date;


    selectTime(
        booking.time
    );


    document.getElementById(
        "booking"
    ).scrollIntoView({
        behavior: "smooth"
    });

}


// ================= CANCEL =================

function cancelBooking() {

    const confirmation =
        confirm(
            "Are you sure you want to cancel this booking?"
        );


    if (confirmation) {

        localStorage.removeItem(
            "salonBooking"
        );


        displayBooking();


        alert(
            "Booking cancelled successfully."
        );

    }

}


// ================= LOGIN =================

document
    .getElementById("loginForm")
    .addEventListener("submit", function(event) {

        event.preventDefault();


        const email =
            document.getElementById(
                "loginEmail"
            ).value;


        alert(
            "Login successful for: "
            + email
        );

    });


// ================= LOAD BOOKING =================

window.addEventListener(
    "load",
    function() {

        displayBooking();

    }
);
