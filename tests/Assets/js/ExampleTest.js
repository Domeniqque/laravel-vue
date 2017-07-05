const assert = require('chai').assert

describe('Array', () => {
    describe('#indexOf', () => {
        it('shoud return -1 when the value is not present', () => {
            assert.equal(-1, [1,2,3].indexOf(4))
        })
    })
})