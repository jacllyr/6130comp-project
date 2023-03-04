use runnersCrispsDB;

db.codes.drop();
db.users.drop();

// Function to generate random 10 digit hex code
function Generate10HexCode() {
    let voucherCode;
    do {
        let result = [];
        let hexPattern = ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9', 'a', 's', 'd', 'f'];

        for (let n = 0; n < 10; n++) {
            result.push(hexPattern[Math.floor(Math.random() * 16)]);
        }

        voucherCode = result.join('');
    } while (!GenerateNewCodes.has(voucherCode));

    GenerateNewCodes.add(voucherCode);
    return voucherCode;
}

const codes = [];
const GenerateNewCodes = new Set();

// For testing purposes
db.codes.insertMany([
    { '_id': 99998, 'voucherCode': '1234567890' },
    { '_id': 99998, 'voucherCode': '1234567891' },
    { '_id': 99997, 'voucherCode': '1234567892' }
]);

// Generate the codes
db.codes.findOne({ 'code': '1234567890' })
db.users.insertOne({})
