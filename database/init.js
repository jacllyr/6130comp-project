use RunnersCrispsDB;

// Drop the collections to avoid duplicates
db.getCollection("codes").drop();
db.getCollection("users").drop();

// Function to generate random 10 digit hex code
function Generate10HexCode() {
    let result = [];
    let hexRef = ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9', 'a', 'b', 'c', 'd', 'e', 'f'];

    for (let n = 0; n < 10; n++) {
        result.push(hexRef[Math.floor(Math.random() * 16)]);
    }
    return result.join('');
}

const codes = [];
const MakeRandomCodes = new Set();
let footballs = 100; // Number of football vouchers to generate

// Generate 1000 random codes
for (let index = 0; index < 1000; index++) {
    // 900 of vouchers will be 10% off and 100 vouchers will be football vouchers
    let voucherCode = Generate10HexCode();

    // Ensure that the voucher code is unique
    while (MakeRandomCodes.has(voucherCode)) {
        voucherCode = Generate10HexCode();
    }

    // Determine if the voucher is a football voucher
    let footballVoucher = false;
    if (footballs > 0) {
        footballVoucher = true;
        footballs--;
    }

    // Add the voucher code to the set of generated codes
    MakeRandomCodes.add(voucherCode);

    // Add the voucher code to the codes array
    codes.push({ '_id': new ObjectId(), 'voucherCode': voucherCode, 'used': false, 'football': footballVoucher });

    // Log the generated voucher code
    console.log("Generated voucher code: " + voucherCode);
}


// For testing purposes, add some specific codes.
codes.push({ '_id': ObjectId("5f1d2d7e8cde0f0172b84c99"), 'voucherCode': '1234567890', 'used': false, 'football': true }); // Football voucher
codes.push({ '_id': ObjectId("5f1d2d7e8cde0f0172b84c98"), 'voucherCode': '1111111111', 'used': false, 'football': false }); // 10% off voucher
codes.push({ '_id': ObjectId("5f1d2d7e8cde0f0172b84c97"), 'voucherCode': '2222222222', 'used': true, 'football': false }); // Used voucher

// Insert the codes into the database
db.getCollection("codes").insertMany(codes);

// Prints the generated voucher codes in the docker container
codes.forEach(code => {
    print("Generated voucher codes: " + code.voucherCode);
});

// Insert a sample user record
// db.users.insertOne({'fullName': 'Jac Llyr', 'email': 'cmpjtho1@ljmu.ac.uk.com', 'address': 'James Parsons Building, Byrom Street, Liverpool L3 3AF', 'bestPlayer': 'Fernando Torres', 'voucherCode' : '1234567890'});
