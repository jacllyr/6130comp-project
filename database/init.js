use RunnersCrispsDB;

// Function to generate random 10 digit hex code
function Generate10HexCode() {
    let result = [];
    let hexRef = ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9', 'a', 's', 'd', 'f'];

    for (let n = 0; n < 10; n++) {
        result.push(hexRef[Math.floor(Math.random() * 14)]);
    }
    return result.join('');
}

// Drop the collections to avoid duplicates
db.codes.drop();
db.users.drop();

const codes = [];
const MakeRandomCodes = new Set();
let footballs = 10;

// Generate 1000 random codes
for (let index = 0; index < 100000; index++) {
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
    codes.push({ '_id': voucherCode, 'used': false, 'football': footballVoucher });

    // Print the generated voucher code to the console
    console.log(`Generated voucher code: ${voucherCode}`);
}

// For testing
codes.push({ '_id': 1, 'voucherCode': '1234567890', 'used': false, 'football': true });
codes.push({ '_id': 2, 'voucherCode': '1111111111', 'used': false, 'football': false });
codes.push({ '_id': 3, 'voucherCode': '2222222222', 'used': true, 'football': false });

// Insert the codes into the database
db.codes.insertMany(codes);

// Insert a sample user record
db.users.insertOne({ 'fullName': 'jac', 'email': 'jac@example.com', 'address': '123 Main St', 'bestPlayer': 'Ronaldo', 'voucherCode': 'ffffffffff' });
