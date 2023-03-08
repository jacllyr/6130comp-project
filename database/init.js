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
for (let index = 0; index < 1000; index++) { // 900 of vouchers to ne 10% off and 100 football voucher
    let voucherCode = Generate10HexCode();
    while (MakeRandomCodes.has(voucherCode)) {
        voucherCode = Generate10HexCode();
    }

    let footballVoucher = false;

    if (footballs > 0) {
        footballVoucher = true;
        footballs--;
    }

    MakeRandomCodes.add(voucherCode);
    codes.push({'voucherCode': voucherCode, 'used': false, 'football': footballVoucher });

    // Print the generated voucher code to the console
    print("Generated voucher code: " + voucherCode);
}

// For testing purposes, add some specific codes.
codes.push({'_id': 1, 'voucherCode': '1234567890', 'used': false, 'football': true }); // Football voucher
codes.push({'_id': 2, 'voucherCode': '1111111111', 'used': false, 'football': false }); // 10% off voucher
codes.push({'_id': 3, 'voucherCode': '2222222222', 'used': true, 'football': false }); // Used voucher

// Insert the codes into the database
db.getCollection("codes").insertMany(codes);

// Insert a sample user record
// db.users.insertOne({'fullName': 'Jac Llyr', 'email': 'cmpjtho1@ljmu.ac.uk.com', 'address': 'James Parsons Building, Byrom Street, Liverpool L3 3AF', 'bestPlayer': 'Fernando Torres', 'voucherCode' : '1234567890'});

