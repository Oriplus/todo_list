module.exports = {
  moduleFileExtensions: ['js', 'json', 'vue'],
  transform: {
    "^.+\\.js$": "babel-jest",
    '^.+\\.vue$': '@vue/vue2-jest',
  },
  testMatch: [
    '<rootDir>/tests/jest/**/*.(spec|test).[jt]s?(x)'
  ],
  moduleNameMapper: {
    '^@/(.*)$': '<rootDir>/src/$1'
  },
  testEnvironment: 'jsdom'
};
